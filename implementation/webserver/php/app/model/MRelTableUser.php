<?php

/**
 * Model for relative table of users. Used to store list of users that are included in specific collection.
 */
class MRelTableUser extends MModel {
    /**
     * @var MRTRUser $items
     * Array of table-row models. One table-row corresponds to one user.
     */
    public $items = array();

    /**
     * Constructs model using data from database.
     * @param $collId Id of collection this model is created for.
     */
    public function __construct($collId) {
        if($collId) {
            $sqls=DB::query("SELECT * FROM collection_users WHERE coll_id=$collId");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRUser($o->user_id);
            }
        }
    }

    /**
     * If collId is supplied, removes all records between this collection and any user,
     * and then re-adds them using data supplied in POST by user.
     * @param null $collId Id of collection this model is created for.
     * @return bool Storing was successful.
     */
    public function store($collId = NULL) {
        if (!$collId) return false;
        $sql = "DELETE FROM collection_users WHERE coll_id=$collId";
        if (FALSE===DB::exec($sql)) return FALSE;

        foreach ($this->items as $item) {
            if(!$item->store($collId)) return false;
        }
        return true;
    }

    /**
     * Removes one specific row from the table.
     * @param MRTRUser $itemModel Model of the deleted row.
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
        $this->items[] = new MRTRUser(0);
    }
}