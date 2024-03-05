<?php

class MRTRCollection extends MModel {
    public $collId;

    public function __construct($collId) {
        $this->collId = $collId;
    }

    public function store($deviceId) {
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