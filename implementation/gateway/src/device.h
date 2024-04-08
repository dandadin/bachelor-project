#ifndef __device_h__
#define __device_h__
#include <string>
#include <rapidjson/document.h>

class Device {
public:
    Device(const std::string& str);
    virtual bool send(const std::string& channel, const std::string& data) = 0;
    virtual std::string recv(const std::string& channel) = 0;
};

typedef Device* (*createinst_t)(const rapidjson::Value&);

#ifdef __cplusplus
extern "C" {
#endif
Device* createInstance(const rapidjson::Value& loadedJson);
#ifdef __cplusplus
}
#endif
#endif
