<?php

class MRelTableCollection extends MModel {
    public $items = array();

    public function __construct($deviceId) {
        if($deviceId) {
            $sqls=DB::query("SELECT * FROM collection_devices WHERE device_id=$deviceId");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRCollection($o->coll_id);
            }
        }
    }

    public function store($deviceId) {
        $sql = "DELETE FROM collection_devices WHERE device_id=$deviceId";
        if (FALSE===DB::exec($sql)) return FALSE;

        foreach ($this->items as $item) {
            if(!$item->store($deviceId)) return false;
        }
        return true;
    }

    public function delete($deviceId) {
        if (!$deviceId) return TRUE;
        $sql = "DELETE FROM collection_devices WHERE device_id=$deviceId";
        if (FALSE===DB::exec($sql)) return FALSE;
        return TRUE;
    }

    public function addItem() {
        error_log("jsem tu");
        $this->items[] = new MRTRCollection(0);
    }
}