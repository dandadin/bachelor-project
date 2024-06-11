<?php
class MQTT {
    protected $mqttCli;
    static $Instance;

    const serviceTopic = '$CONTROL/dynamic-security/v1';

    public function __construct() {
        if (static::$Instance) {
            error_log("Warn: MQTT Connection already established.");
            return;
        }

        $server   = 'mqttbroker';
        $port     = 1883;
        $clientId = 'webserver';
        $mqttCli = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
        $connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
            ->setReconnectAutomatically(true)
            ->setUsername("webserver")
            ->setPassword("revresbew");
        $mqttCli->connect($connectionSettings);
        static::$Instance = $this;
        $this->mqttCli = $mqttCli;
        error_log("Info: MQTT Connection successfully established.");
    }

    public function __destruct() {
        $this->mqttCli?->disconnect();
        if (static::$Instance == $this) static::$Instance = null;
    }


    static function send(string $topic, string $msg, bool $retain = false) : void {
        //error_log(var_export(static::$Instance->mqttCli, true));
        while (!static::$Instance->mqttCli) usleep(500);
        static::$Instance->mqttCli->publish($topic, $msg, 0, $retain);
        error_log(">>>>>>>MQTT:send(): topic: $topic, msg: $msg, retain: $retain");
    }

    static function get(string $tpc) : string {
        $msg = "";

        static::$Instance->mqttCli->subscribe($tpc, function ($topic, $message, $retained, $matchedWildcards) use ($msg) {
            echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
            $msg = $message;
            global $mqtt;
            static::$Instance->mqttCli->interrupt();
        }, 0);
        static::$Instance->mqttCli->loop(true);
        static::$Instance->mqttCli->unsubscribe($tpc);
        return $msg;
    }

    static function createClient(string $client, string $token, string $role) : void {
        $msg = <<<END
{
	"commands":[
		{
			"command": "createClient",
			"username": "$client",
			"password": "$token",
			"roles": [
				{ "rolename": "$role", "priority": -1 }
			]
		}
	]
}
END;
        static::send(static::serviceTopic, $msg);
        error_log("Info: CREATE CLIENT MQTT: \n".$msg."\n>>END");
    }

    static function createRole(string $role, array $acls) : void {
        $msg = <<<END
{
	"commands":[
		{
			"command": "createRole",
			"rolename": "$role",
			"acls": [
END;
        $first = true;
        foreach ($acls as $acl) {
            if ($first) $first = false; else $msg.=",";
            $msg .= "{\"acltype\": \"$acl[0]\", \"topic\": \"$acl[1]\", \"priority\": -1, \"allow\": true }";
        }

        $msg .= "]}]}";
        static::send(static::serviceTopic, $msg);
        error_log("Info: CREATE ROLE MQTT: \n".$msg."\n>>END");
    }

    static function removeRole(string $role) : void {
        $msg = <<<END
{
	"commands":[
		{
			"command": "deleteRole",
			"rolename": "$role"
		}
	]
}
END;
        static::send(static::serviceTopic, $msg);
    }

    static function removeClient(string $client) : void {
        $msg = <<<END
{
	"commands":[
		{
			"command": "deleteClient",
			"username": "$client"
		}
	]
}
END;
        static::send(static::serviceTopic, $msg);
    }
}