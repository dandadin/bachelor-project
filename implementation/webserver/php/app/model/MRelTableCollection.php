<?php

/**
 * Model for relative table of collections. Used to store list of collections that include specific device.
 */
class MRelTableCollection extends MModel {
    /**
     * @var MRTRCollection $items
     * Array of table-row models. One table-row corresponds to one collection.
     */
    public $items = array();

    /**
     * Constructs model using data from database.
     * @param $deviceId Id of device this model is created for.
     */
    public function __construct($deviceId) {
        if($deviceId) {
            $sqls=DB::query("SELECT * FROM collection_devices WHERE device_id=$deviceId");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRCollection($o->coll_id);
            }
        }
    }

    /**
     * If deviceId is supplied, removes all records between this device and any collection,
     * and then re-adds them using data supplied in POST by user.
     * @param $deviceId Id of device this model is created for.
     * @return bool Storing was successful.
     */
    public function store($deviceId = NULL) {
        if (!$deviceId) return false;
        $sql = "DELETE FROM collection_devices WHERE device_id=$deviceId";
        if (false===DB::exec($sql)) return false;

        foreach ($this->items as $item) {
            if(!$item->store($deviceId)) return false;
        }
        return true;
    }

    /**
     * Removes one specific row from the table.
     * @param MRTRCollection $itemModel Model of the deleted row.
     * @return void
     */
    public function deleteItem(&$itemModel) {
        if (($key = array_search($itemModel, $this->items)) !== false) {
            unset($this->items[$key]);
        }
    }

    /**
     * Adds new default row to the table.
     * @return void
     */
    public function addItem() {
        $this->items[] = new MRTRCollection(0);
    }
}