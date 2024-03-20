<?php

class Communicator {
    public static function sendStep(int $stepId) : void {
        $sqls=DB::query("SELECT * FROM steps s WHERE s.id=$stepId");
        $o=$sqls->fetchObject();
        self::send($o->channel_id, $o->value);
    }

    public static function send(int $channelId, string $data) : void {
        $sql = "SELECT g.address AS gaddress FROM channels c LEFT JOIN devices d on d.id = c.device_id LEFT JOIN gateways g on g.id = d.gateway_id WHERE c.id=$channelId";
        error_log($sql);
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();
        echo ">>>>>>>>COMM: Odesilam \"$data\" na adresu \"$o->gaddress\". <br>";
    }

    public static function loadGateway(int $gatewayId) : bool {
        $sql = "SELECT * FROM gateways g WHERE g.id=$gatewayId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();
        if (!$o) {
            error_log("ERROR: loadGateway: No gateway with this ID.");
            return false;
        }
        $config = self::downloadGWConfig($o->address);
        if (!isset($config) || $config["name"] != $o->name) {
            error_log("ERROR: loadGateway: Gateway names not matching!");
            return false;
        }

        return self::parseAndPersistGWConfig($gatewayId, $config);
    }

    private static function downloadGWConfig(string $addr) : array|null {
        $address = str_ends_with($addr, "/") ? rtrim($addr, "/") : $addr;
        if (!file_put_contents("/tmp/config.json", fopen($address."/config.json", 'r'))) {
            error_log("ERROR: loadGateway: Problem downloading config.");
            return null;
        }
        $json = file_get_contents("/tmp/config.json");
        if (!$json) {
            error_log("ERROR: loadGateway: No JSON file loaded.");
            return null;
        }
        $config = json_decode($json, true);
        error_log(var_export($config, true));
        return $config;
    }

    private static function parseAndPersistGWConfig(int $gatewayId, array $config) : bool {
        $sql = "SELECT * FROM devices WHERE name=$gatewayId";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();

        foreach ($config["devices"] as $device) {
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

            foreach ($device["channels"] as $channel) {
                $sql = "SELECT * FROM channels WHERE name='".$channel["name"]."' AND device_id=$id";
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
                        "device_id" => $id,
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
            }

        }
        return true;
    }
}