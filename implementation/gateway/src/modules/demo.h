#ifndef __demo_h_
#define __demo_h_

#include <string>
#include "device.h"

class Demo : public Device {
public:
    Demo(const std::string& str);
    bool send(const std::string &channel, const std::string &data) override;
    std::string recv(const std::string &channel) override;
};

#endif
