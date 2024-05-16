<?php

/**
 * @brief Model for gateway object.
 */
class MGateway extends MObjectModel {
    /**
     * @const urlPrefix
     * Used for generating url for this model.
     */
    const urlPrefix = 'gateway';
    /**
     * @var $name
     * Name of gateway loaded from database.
     */
    public $name;
    /**
     * @var $address Web address of gateway loaded from database.
     */
    public $address;
    /**
     * @var $config Json structure consisting of data describing gateway and its settings. It is loaded from gateway config obtained directly from gateway.
     */
    public $config;
    /**
     * @var $tmpId
     * Id that is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * Constructs model using data from database.
     * @param $id Id of gateway in database.
     */
    public function __construct($id = 0) {
        parent::__construct();
        if($id) {
            $sqls=DB::query("SELECT * FROM gateways WHERE id=$id");
            $o=$sqls->fetchObject();
            if ($o) {
                $this->id = $o->id;
                $this->name = $o->name;
                $this->address = $o->address;
            }
        }
    }

    /**
     * @brief Tries to store data to database.
     * @param null $arg Universal argument, not used here.
     * @return bool Storing was successful.
     */
    public function store(int $arg = 0) : bool {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" gateways SET name=:name, address=:address";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["name" => $this->name, "address" => $this->address]);
        } catch (PDOException) {
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        if (!$this->id) $this->tmpId = DB::lastInsertId();

        return $this->applyConfig();
    }

    /**
     * @brief Used when storing in database was successful. Commits all changes to model and database.
     * @return void
     */
    public function storeCommit() : void {
        parent::storeCommit();
        if (!$this->id) $this->id = $this->tmpId;
    }

    /**
     * @brief Deletes corresponding record from database.
     * @return bool Deletion was successful.
     */
    public function delete($arg = NULL) : bool {
        if (!$this->id) return TRUE;
        $sql = "DELETE FROM gateways WHERE id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        $sql = "DELETE FROM devices WHERE gateway_id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        if (FALSE===parent::delete()) return FALSE;
        $this->tmpId = NULL;
        return TRUE;
    }

    /**
     * Starts saving process to database.
     * Called when button in edit form using this model is pressed. Adds notification to user about result.
     * @return void
     */
    public function clickedSubmit() {
        if ($this->persist()) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Gateway was saved."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Gateway could not have been saved!"));

    }

    /**
     * Starts saving process to database.
     * Called when button in edit form using this model is pressed. Adds notification to user about result.
     * @return void
     */
    public function clickedLoad() {
        if (Communicator::loadGatewayConfig($this)) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Gateway config was loaded."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Gateway config could not have been loaded!"));
    }

    /**
     * Starts deleting process in database.
     * If not successful, reverts changes made. Adds notification to user about result.
     * @return bool
     */
    public function unpersist() : bool {
        $ret = parent::unpersist();
        if ($ret) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Gateway was deleted."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Gateway could not have been saved!"));
        return $ret;
    }

    /**
     * Takes loaded gateway config and tries to apply it to MQTT broker and database.
     * @return bool True if successful.
     */
    private function applyConfig() {
        $sql = "SELECT * FROM devices WHERE name=$this->id";
        $sqls=DB::query($sql);
        $o=$sqls->fetchObject();

        if (!$this->config) return true;

        $updatedDevices = array();
        foreach ($this->config["devices"] as $device) if(!$this->updateOrInsertDevice($device, $updatedDevices)) {
            error_log("Error: UpdateOrInsert of device(id:".$device["name"]." not successful!");
            return false;
        }
        if(!$this->deleteNotUpdated("SELECT id FROM devices WHERE gateway_id=$this->id", $updatedDevices, "MDevice")) {
            error_log("Error: DeleteNotUpdated failed!");
            return false;
        }
        MQTTWS::createGW($this->config["address"], $this->config["token"]);
        return true;
    }

    /**
     * Tries to update/insert a device to database, takes data from $device JSON-like array.
     * @param array $device Imported JSON device config
     * @param array $updatedDevices Array of booleans indexed by deviceId. Value is TRUE, if the device was mentioned in the config. Used for removing old devices that are no longer present in config (using deleteNotUpdated function).
     * @return bool True if process was successful
     */
    private function updateOrInsertDevice(array $device, array &$updatedDevices) : bool {
        $sql = "SELECT * FROM devices WHERE name='".$device["name"]."' AND gateway_id=$this->id";
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
                "gateway_id" => $this->id,
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
        foreach ($device["channels"] as $channel) if(!$this->updateOrInsertChannel($id, $channel, $updatedChannels)) {
            error_log("Error: UpdateOrInsert of channel(id:".$channel["name"]." not successful!");
            return false;
        }
        return $this->deleteNotUpdated("SELECT id FROM channels WHERE device_id=$id", $updatedChannels, "MChannel");
    }

    /**
     * Tries to update/insert a channel to database, takes data from $channel JSON-like array.
     * @param int $deviceId Id of device this channel should be part of
     * @param array $channel Imported JSON channel config
     * @param array $updatedChannels Array of booleans indexed by channelId. Value is TRUE, if the channel was mentioned in the config. Used for removing old channels that are no longer present in config (using deleteNotUpdated function).
     * @return bool True if process was successful
     */
    private function updateOrInsertChannel(int $deviceId, array $channel, array &$updatedChannels) : bool {
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

    /**
     * Deletes model of type $modelClass with id $id from database.
     * @param int $id Id of model to be deleted.
     * @param string $modelClass Model class of model to be deleted.
     * @return bool True if deletion was successful
     */
    private function deleteModel(int $id, string $modelClass) : bool {
        $model = new $modelClass($id);
        return $model->delete();
    }

    /**
     * Deletes all results of $sql query, that are not also present in the $updatedArray array. Used for removing no-longer-needed records from the database.
     * @param string $sql SQL query that selects all records to be evaluated.
     * @param array $updatedArray Array of booleans indexed by Id of records used in $sql query. $updatedArray[$Id]=FALSE if model($Id) should be deleted from database.
     * @param string $modelClass Model class of records in $sql
     * @return bool True if everything successful
     */
    private function deleteNotUpdated(string $sql, array $updatedArray, string $modelClass) : bool {
        $sqls=DB::query($sql);
        while($o=$sqls->fetchObject()) {
            if (!(isset($updatedArray[$o->id]) && $updatedArray[$o->id] == true)) {
                if (!$this->deleteModel($o->id, $modelClass)) {
                    error_log("Error: Deletion of $modelClass(id:$o->id) not successful!");
                    return false;
                }
            }
        }
        return true;
    }
}