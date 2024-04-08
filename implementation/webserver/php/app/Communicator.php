<?php

class Communicator {
    public static function sendStep(int $stepId) : void {
        $sqls=DB::query("SELECT * FROM steps s WHERE s.id=$stepId");
        $o=$sqls->fetchObject();
        self::send($o->channel_id, $o->value);
    }

    public static function send(int $channelId, string $data) : void {
        $sql = "SELECT g.address AS gaddress, c.name AS cname FROM channels c LEFT JOIN devices d on d.id = c.device_id LEFT JOIN gateways g on g.id = d.gateway_id WHERE c.id=$channelId";
        error_log($sql);
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();
        echo ">>>>>>>>COMM: Odesilam \"$data\" na adresu \"$o->gaddress\". <br>";
        MQTTWS::sendStep($o->gaddress, $o->cname, $data);
    }

    /**
     * Loads config from gateway device over MQTT.
     * @param MGateway $gatewayModel Model of gateway the config should be loaded from.
     * @return bool Loading was successful.
     */
    public static function loadGatewayConfig(MGateway $gatewayModel) : bool {
        $config = self::getGWConfigFromMQTT($gatewayModel->address);
        if (!isset($config)) {
            error_log("ERROR: loadGatewayConfig: Config not found!");
            return false;
        }
        $gatewayModel->config = $config;
        return true;
    }

    /**
     * Loads config file of gateway with MAC address $address from gateway device over MQTT.
     * @param string $address MAC address of gateway.
     * @return array|null JSON config of gateway. Null if config is not found (or there is more than one).
     */
    private static function getGWConfigFromMQTT(string $address) : array|null {
        $configs = MQTTWS::getConfigs();
        $res = null;
        foreach ($configs as $c) {
            if ($c["address"] == $address) {
                if (!$res) $res = $c;
                else return null;
            }
        }
        return $res;
    }

    public static function loadGateway(int $gatewayId) : bool {
        $sql = "SELECT * FROM gateways g WHERE g.id=$gatewayId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();
        if (!$o) {
            error_log("ERROR: loadGateway: No gateway with this ID.");
            return false;
        }
        $config = self::getGWConfig($o->address);
        error_log("Vysledek z getGWConfigu: ".var_export($config, true));
        error_log("Ocekavane jmeno ve vysledku: ".var_export($o->name, true));
        if (!isset($config) || $config["name"] != $o->name) {
            error_log("ERROR: loadGateway: Gateway names not matching!");
            return false;
        }

        return self::parseAndPersistGWConfig($gatewayId, $config);
    }

    private static function getGWConfig(string $address) : array|null {
        $configs = MQTTWS::getConfigs();
        $res = null;
        foreach ($configs as $c) {
            if ($c["address"] == $address) {
                if (!$res) $res = $c;
                else return null;
            }
        }
        return $res;
    }

    private static function parseAndPersistGWConfig(int $gatewayId, array $config) : bool {
        $sql = "SELECT * FROM devices WHERE name=$gatewayId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();

        $updatedDevices = array();
        foreach ($config["devices"] as $device) if(!Communicator::updateOrInsertDevice($gatewayId, $device, $updatedDevices)) {
            error_log("Error: UpdateOrInsert of device(id:".$device["name"]." not successful!");
            return false;
        }
        if(!self::deleteNotUpdated("SELECT id FROM devices WHERE gateway_id=$gatewayId", $updatedDevices, "MDevice")) {
            error_log("Error: DeleteNotUpdated failed!");
            return false;
        }
        MQTTWS::createGW($config["address"], $config["token"]);
        return true;
    }

    private static function updateOrInsertDevice(int $gatewayId, array $device, array &$updatedDevices) : bool {
        $sql = "SELECT * FROM devices WHERE name='".$device["name"]."' AND gateway_id=$gatewayId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();

        $sql = $o ? "UPDATE" : "INSERT INTO";
        $sql.=" devices SET name=:name, location=:location, gateway_id=:gateway_id,"
            ." last_changed=:last_changed, domain_id=1";
        if ($o) $sql.=" WHERE id=$o->id";
        $sqls=DB::prepare($sql);

        $res = true;
        try {
            $res = $sqls->execute(["name" => $device["name"], "location" => $device["location"],
                "gateway_id" => $gatewayId,
                "last_changed" => timetostr(time())]);
        } catch (PDOException $e) {
            $res = false;
            error_log($e->getMessage());
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        $id = ($o ? $o->id : DB::lastInsertId());
        $updatedDevices[$id] = true;

        $updatedChannels = array();
        foreach ($device["channels"] as $channel) if(!Communicator::updateOrInsertChannel($id, $channel, $updatedChannels)) {
            error_log("Error: UpdateOrInsert of channel(id:".$channel["name"]." not successful!");
            return false;
        }
        return self::deleteNotUpdated("SELECT id FROM channels WHERE device_id=$id", $updatedChannels, "MChannel");
    }

    private static function updateOrInsertChannel(int $deviceId, array $channel, array &$updatedChannels) : bool {
        $sql = "SELECT * FROM channels WHERE name='".$channel["name"]."' AND device_id=$deviceId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();

        $sql = $o ? "UPDATE" : "INSERT INTO";
        $sql.=" channels SET name=:name, device_id=:device_id, comm_type=:comm_type,".
            " value_type=:value_type, update_freq=:update_freq";
        if ($o) $sql.=" WHERE id=$o->id";
        $sqls=DB::prepare($sql);

        $res = true;
        try {
            $res = $sqls->execute(["name" => $channel["name"],
                "device_id" => $deviceId,
                "comm_type" => $channel["comm"],
                "value_type" => $channel["value"],
                "update_freq" => $channel["update_freq"]]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        $id = ($o ? $o->id : DB::lastInsertId());
        $updatedChannels[$id] = true;
        return true;
    }

    private static function deleteModel(int $id, string $modelClass) : bool {
        $model = new $modelClass($id);
        return $model->delete();
    }

    private static function deleteNotUpdated(string $sql, array $updatedArray, string $modelClass) : bool {
        $sqls=DB::query($sql);
        while($o=$sqls->fetchObject()) {
            if (!(isset($updatedArray[$o->id]) && $updatedArray[$o->id] == true)) {
                if (!self::deleteModel($o->id, $modelClass)) {
                    error_log("Error: Deletion of $modelClass(id:$o->id) not successful!");
                    return false;
                }
            }
        }
        return true;
    }
}