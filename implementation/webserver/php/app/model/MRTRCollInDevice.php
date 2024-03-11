<?php

/**
 * Model of table-row of relative table of collections. Stores single collection.
 */
class MRTRCollInDevice extends MModel {
    /**
     * @var $collId
     * Id of collection this row used for creation.
     */
    public $collId;

    /**
     * Constructs model using data from database.
     * @param int $collId Id of device this model is created for.
     */
    public function __construct(int $collId = 0) {
        $this->collId = $collId;
    }

    /**
     * If deviceId is specified, inserts this row into database.
     * @param $deviceId Id of device this collection should be paired with.
     * @return bool Storing was successful.
     */
    public function store(int $deviceId = 0) {
        if (!$deviceId) return false;
        $sql = "INSERT INTO collection_devices (coll_id, device_id) ".
               "SELECT id,:deviceId FROM collections WHERE id=:collId ".
               "ON DUPLICATE KEY UPDATE coll_id=coll_id";

        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["deviceId" => $deviceId, "collId" => $this->collId]);
        } catch (PDOException) {$res = false;}
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        return true;
    }
}