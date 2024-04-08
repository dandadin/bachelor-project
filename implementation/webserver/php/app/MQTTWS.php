<?php
class MQTTWS extends MQTT {

    static function createGW(string $gwName, string $token) : void {
        $name = "GW/".$gwName;
        $topic = "GW/".$gwName."/#";
        parent::createRole($name, [
            ["subscribePattern", $topic],
            ["unsubscribePattern", $topic],
            ["publishClientSend", $topic],
            ["publishClientReceive", $topic],
            ["subscribePattern", "GetConfigs"],
            ["unsubscribePattern", "GetConfigs"],
            ["publishClientSend", "Configs"],
            ["publishClientReceive", "GetConfigs"],
            ["subscribePattern", "RegisteredGW"],
            ["unsubscribePattern", "RegisteredGW"],
            ["publishClientReceive", "RegisteredGW"]] );
        parent::createClient($name, $token, $name);
        self::send("RegisteredGW", $gwName);
        error_log("Info: MQTT 'RegisteredGW' message sent (".$gwName.")");
    }

    static function removeGW(string $gwName) : void {
        $name = "GW/".$gwName;
        parent::removeClient($gwName);
        parent::removeRole($name);
    }


    static function getConfigs() : array {
        $msgs = array();
        static::$Instance->mqttCli->subscribe("Configs", function ($topic, $message, $retained, $matchedWildcards) use (&$msgs) {
            error_log("Received message on topic [".$topic."]: ".$message."\n");
            $msgs[] = $message;
        }, 0);
        MQTTWS::send("GetConfigs", "publish");
        static::$Instance->mqttCli->loop(true, false, 2);
        static::$Instance->mqttCli->unsubscribe("Configs");

        $configs = array();
        foreach ($msgs as $msg) {
            $config = json_decode($msg, true);
            $configs[] = $config;
        }
        return $configs;
    }

    static function sendStep(string $gwMAC, string $channelName, string $data) {
        MQTTWS::send("GW/".$gwMAC."/".$channelName, $data);
    }
}