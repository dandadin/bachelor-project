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
     * @param $collId Id of device this model is created for.
     */
    public function __construct($collId) {
        $this->collId = $collId;
    }

    /**
     * If deviceId is specified, inserts this row into database.
     * @param $deviceId Id of device this collection should be paired with.
     * @return bool Storing was successful.
     */
    public function store($deviceId = NULL) {
        if (!$deviceId) return false;
        $sql = "INSERT INTO collection_devices (coll_id, device_id) ".
               "SELECT id,:deviceId FROM collections WHERE id=:collId";

        $sqls=DB::prepare($sql);
        if (!$sqls->execute(["deviceId" => $deviceId, "collId" => $this->collId]))
        {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        return true;
    }
}