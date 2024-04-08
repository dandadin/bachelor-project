#include <iostream>
#include "demo.h"

Demo::Demo(const std::string &str): Device(str) {}

bool Demo::send(const std::string &channel, const std::string &data) {
    std::cout << "PACKAGE TO CHANNEL '"+channel+"': '"+data+"'" << std::endl;
    return true;
}

std::string Demo::recv(const std::string &channel) {
    return "'"+channel+"': '1'";
}

Device* createInstance(const rapidjson::Value& loadedJson) {
    const std::string tmp = loadedJson["name"].GetString();
    return new Demo(tmp);
}