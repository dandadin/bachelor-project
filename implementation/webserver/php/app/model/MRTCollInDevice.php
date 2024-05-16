<?php

/**
 * Model for relative table of collections. Used to store list of collections that include specific device.
 */
class MRTCollInDevice extends MRelTable {
    const RowModelClass = MRTRCollInDevice::class;
    /**
     * Constructs model using data from database.
     * @param $deviceId Id of device this model is created for.
     */
    public function __construct($deviceId) {
        if($deviceId) {
            $sqls=DB::query("SELECT * FROM collection_devices WHERE device_id=$deviceId ");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRCollInDevice($o->coll_id);
            }
        }
    }

    /**
     * If deviceId is supplied, removes all records between this device and any collection,
     * and then re-adds them using data supplied in POST by user.
     * @param int $deviceId Id of device this model is created for.
     * @return bool Storing was successful.
     */
    public function store(int $deviceId = 0) : bool {
        if (!$deviceId) return false;
        $sql = "DELETE FROM collection_devices WHERE device_id=$deviceId";
        if (false===DB::exec($sql)) return false;

        if(!parent::store($deviceId)) return false;

        return true;
    }
}