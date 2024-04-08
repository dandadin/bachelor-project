#include <cstdio>
#include <csignal>
#include <string>
#include <mosquitto.h>
#include <iostream>
#include <fstream>
#include <rapidjson/document.h>
#include <map>
#include <dlfcn.h>
#include <vector>
#include <sstream>
#include "device.h"

#define mqtt_host "iothome.cz"
#define mqtt_port 1883

#define MQTT_GETCONFIG_TOPIC "GetConfigs"
#define MQTT_SENDCONFIG_TOPIC "Configs"
#define MQTT_REGISTEREDGW_TOPIC "RegisteredGW"
#define MQTT_CONFIG_FILE "/win/Users/dansi/bachelor-project/implementation/gateway/src/gateway_example_config.json"

using namespace std;

static int wantToRun = 1;
static bool anonymousConnect = false;
static int retCode = 69;
string configFile = MQTT_CONFIG_FILE;
static mosquitto* mosqq;

string address, tmpAddress;
string token, tmpToken;
map<string, Device*> *deviceCommHandlers, *tmpDeviceCommHandlers;
map<string, createinst_t> loadedModules;
map<string, string> *devices, *tmpDevices;

vector<string> splitString (const string& input, char delimiter) {
    std::stringstream iss(input);
    std::string segment;
    std::vector<std::string> retVal;

    while (std::getline(iss, segment, delimiter)) {
        retVal.push_back(segment);
    }

    return retVal;
}

void changeIdentity(struct mosquitto *mosq, bool anonymous = true, const string& username = "", const string& password = "") {
    if (anonymousConnect && anonymous) return;
    if (!anonymousConnect && anonymous) {
        mosquitto_username_pw_set(mosq, nullptr, nullptr);
        anonymousConnect = true;
    }
    if (!anonymous) {
        mosquitto_username_pw_set(mosq, username.c_str(), password.c_str());
        anonymousConnect = false;
    }
    mosquitto_reconnect(mosq);
}

void multiSubscribe(struct mosquitto *mosq, bool anonymous = true) {
    mosquitto_subscribe(mosq, NULL, MQTT_GETCONFIG_TOPIC, 0);
    mosquitto_subscribe(mosq, NULL, MQTT_REGISTEREDGW_TOPIC, 0);
    if (!anonymous) {
        mosquitto_subscribe(mosq, NULL, ("GW/" + address + "/#").c_str(), 0);
    }
}

void commitChanges() {
    address = tmpAddress;
    token = tmpToken;
    if (deviceCommHandlers) {
        auto it = deviceCommHandlers->begin();
        while (it != deviceCommHandlers->end()) {
            delete it->second;
            ++it;
        }
        delete deviceCommHandlers;
    }
    deviceCommHandlers = tmpDeviceCommHandlers;

    delete devices;
    devices = tmpDevices;
}

bool reloadCachedConfig(const string& filename) {
    ifstream config(filename);
    string json((istreambuf_iterator<char>(config)),
                istreambuf_iterator<char>());
    config.close();
    rapidjson::Document doc;
    doc.Parse(json.c_str());
    if (doc.HasParseError()) {
        cerr << "Error parsing JSON: "
             << doc.GetParseError() << endl;
        return false;
    }
    cout << "addr:[" << doc["address"].GetString() << "]" << endl;
    tmpAddress = doc["address"].GetString();
    cout << "tok:[" << doc["token"].GetString() << "]" << endl;
    tmpToken = doc["token"].GetString();


    const rapidjson::Value& devs = doc["devices"];
    tmpDeviceCommHandlers = new map<string, Device*>;
    tmpDevices = new map<string, string>;
    for (rapidjson::SizeType i = 0; i < devs.Size(); i++) {// Uses SizeType instead of size_t
        if (tmpDeviceCommHandlers->contains(devs[i]["name"].GetString())) {
            cerr << "Error: Found duplicate device names!" << endl;
            return false;
        }

        const string comm_module = devs[i]["comm_module"].GetString();
        if (!loadedModules.contains(comm_module)) {
            cerr << "Info: Loading module '" << comm_module << "' ..." << endl;
            void* handle = dlopen(("./" + comm_module + ".so").c_str(), RTLD_NOW);
            if (!handle) {
                cerr << "Error: Module could not be loaded! Exiting now!" << endl;

                exit(1);
            }
            auto createInstance = (createinst_t)dlsym(handle, "createInstance");
            if (!createInstance) {
                cerr << "Error: Create function not found in module! Exiting now!" << endl;
                exit(2);
            }
            loadedModules.insert(make_pair(comm_module, createInstance));
        }
        createinst_t createInstance = loadedModules.at(comm_module);
        tmpDeviceCommHandlers->insert(make_pair(comm_module, createInstance(devs[i])));
        tmpDevices->insert(make_pair(devs[i]["name"].GetString(), comm_module));
    }


    commitChanges();
    if (devices) {
        int i = 0;
        cout << i <<  " " << devices->size() << endl;
        for (const auto& [key, value]: *devices) {
            cout << ++i << ": " << key << " " << endl;
        }
        cout << endl;
    } else cout << "PROBLEM> zadne zarizeni" << endl;
    return true;
}



void handle_signal(int s) {
    wantToRun = 0;
}

void connect_callback(struct mosquitto *mosq, void *obj, int result) {
    printf("connect callback, returnCode=%d (%s)\n", result, mosquitto_connack_string(result));
    if(result == 5 && !anonymousConnect) {
        changeIdentity(mosq, true);
        multiSubscribe(mosq, true);
    }
}

string getRoleName() {
    return "GW/" + address;
};

void message_callback(struct mosquitto *mosq, void *obj, const struct mosquitto_message *message) {
    bool match = 0;
    printf("got message '%.*s' for topic '%s'\n", message->payloadlen, (char*) message->payload, message->topic);

    mosquitto_topic_matches_sub(MQTT_GETCONFIG_TOPIC, message->topic, &match);
    if (match) {
        printf("got message for GetConfigs topic\n");
        printf("sending config back...\n");
        ifstream inStream;
        inStream.open(configFile);
        string msg((istreambuf_iterator<char>(inStream)),
                             istreambuf_iterator<char>());
        inStream.close();
        sleep(1);
        mosquitto_publish(mosq, NULL, MQTT_SENDCONFIG_TOPIC, msg.size(), msg.c_str(), 0, false);
    }

    mosquitto_topic_matches_sub(MQTT_REGISTEREDGW_TOPIC, message->topic, &match);
    if (match) {
        reloadCachedConfig(configFile);
        changeIdentity(mosq, false, getRoleName(), token);
        multiSubscribe(mosq, false);
    }

    mosquitto_topic_matches_sub(("GW/" + address + "/#").c_str(), message->topic, &match);
    if (match) {
        cout << "Detekoval jsem zpravu v topicu GW/" << endl;
        vector<string> topic = splitString(message->topic, '/');
        if (topic.at(1) != address) {
            cerr << "Warn: Received MQTT message was addressed to a different gateway! ('" + topic.at(1) + "', but my name is '" + address + "')" << endl;
            return;
        }
        if (!devices) {cerr << "Error: Device map not set! Exiting..." << endl; exit(3);}
        if(!devices->contains(topic.at(2))) {
            cerr << "Warn: Received MQTT message was addressed to an unknown device! ('" + topic.at(2) + "')" << endl;
            cerr << "ZNAM POUZE: ";
            for (const auto& [name, handler] : *devices ) {
                cerr << "(" << name << ") ";
            }
            cerr << endl;
            return;
        }
        string msg((char*)message->payload, message->payloadlen);

        if (!deviceCommHandlers) {cerr << "Error: DeviceHandlers map not set! Exiting..." << endl; exit(4);}
        if (!deviceCommHandlers->at(devices->at(topic.at(2)))->send(topic.at(3), msg)) {
            cerr << "Warn: External module error: Message could not be sent to the device/channel! (device: '" + topic.at(2) + "', channel: '"+ topic.at(3) + "', msg: '" + msg + "')" << endl;
            return;
        }
    }
}

int main(int argc, char* argv[]) {
    if (argc > 1) configFile = argv[1];
    char clientId[24];
    struct mosquitto *mosq;
    mosqq = mosq;
    int retVal = 0;

    signal(SIGINT, handle_signal);
    signal(SIGTERM, handle_signal);

    reloadCachedConfig(configFile);

    mosquitto_lib_init();

    memset(clientId, 0, 24);
    snprintf(clientId, 23, "mysql_log_%d", getpid());
    mosq = mosquitto_new(clientId, true, 0);

    if(mosq){
        mosquitto_connect_callback_set(mosq, connect_callback);
        mosquitto_message_callback_set(mosq, message_callback);

        mosquitto_username_pw_set(mosq, getRoleName().c_str(), token.c_str());
        //mosquitto_username_pw_set(mosq, nullptr, nullptr);
        cout << "1RetCode:[" << retCode << "]" << endl;
        mosquitto_connect(mosq, mqtt_host, mqtt_port, 60);
        cout << "2RetCode:[" << retCode << "]" << endl;
        multiSubscribe(mosq, false);
//        mosquitto_subscribe(mosq, NULL, MQTT_GETCONFIG_TOPIC, 0);
//        mosquitto_subscribe(mosq, NULL, MQTT_REGISTEREDGW_TOPIC, 0);
//        mosquitto_subscribe(mosq, NULL, ("GW/" + address + "/#").c_str(), 0);
//        cout << "3RetCode:[" << retCode << "]" << endl;
        cout << "RETVAL:[" << retVal << "]" << endl;
        cout << "jsem pred while" << endl;

        while(wantToRun){
            retVal = mosquitto_loop(mosq, 1000, 1);
            if(wantToRun && retVal){
                printf("Connection error!\n");
                sleep(10);
                mosquitto_reconnect(mosq);
            }
        }
        mosquitto_destroy(mosq);
    }

    mosquitto_lib_cleanup();

    return retVal;
}