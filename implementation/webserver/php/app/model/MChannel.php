<?php

/**
 * @brief Model for channel object.
 */
class MChannel extends MModel {
    /**
     * @var $id
     * Id of channel loaded from database.
     */
    public $id;
    /**
     * @var $name
     * Name od channel loaded from database.
     */
    public $name;
    /**
     * @var $deviceId
     * ID of device of this channel.
     */
    public $deviceId;
    /**
     * @var $commType
     * Type of communication.
     * 1 = only server to device
     * 2 = only device to server
     * 3 = both ways
     */
    public $commType;
    /**
     * @var $valueType
     * Type of value.
     * //TODO: doplnit typy hodnot
     */
    public $valueType;
    /**
     * @var $updateFreq
     * Frequency of updates of this channel in ms.
     */
    public $updateFreq;
    /**
     * @var $tmpId
     * Id that is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * @brief Constructs model using data from database.
     * @param $id Id of channel in database.
     */
    public function __construct($id) {
        if($id) {
            $sqls=DB::query("SELECT * FROM channels WHERE id=$id");
            $o=$sqls->fetchObject();
            if($o) {
                $this->id = $o->id;
                $this->name = $o->name;
                $this->deviceId = $o->device_id;
                $this->commType = $o->comm_type;
                $this->valueType = $o->value_type;
                $this->updateFreq = $o->update_freq;
            }
        }
    }

    /**
     * @brief Tries to store data to database.
     * @return bool Storing was successful.
     */
    public function store(int $arg = 0) {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" channels SET name=:name, device_id=:device_id, comm_type=:comm_type,".
        " value_type=:value_type, update_freq=:update_freq";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["name" => $this->name, "device_id" => $this->deviceId,
            "comm_type" => $this->commType, "value_type" => $this->valueType,
            "update_freq" => $this->updateFreq]);
        } catch (PDOException) {
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        if (!$this->id) $this->tmpId = DB::lastInsertId();
        return true;
    }

    /**
     * @brief Used when storing in database was successful. Commits all changes to model and database.
     * @return void
     */
    public function storeCommit() {
        parent::storeCommit();
        if (!$this->id) $this->id = $this->tmpId;
    }

    /**
     * @brief Deletes corresponding record from database.
     * @return bool Deletion was successful.
     */
    public function delete($arg = NULL) {
        if(!$this->id) return TRUE;
        $sql = "DELETE FROM channels WHERE id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        if (FALSE===parent::delete()) return FALSE;
        $this->tmpId = NULL;
        return TRUE;
    }

    /**
     * Starts saving process to database.
     * Called when button in edit form using this model is pressed.
     * @return void
     */
    public function clickedSubmit() {
        $this->persist();
    }


}