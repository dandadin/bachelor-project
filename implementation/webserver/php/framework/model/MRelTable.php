<?php

/**
 * Model for default relative table. Used to store list of table-row models.
 */
class MRelTable extends MModel {
    /**
     * @var $items
     * Array of table-row models. One table-row is of type MRTR<type>.
     */
    public $items = array();
    const RowModelClass = "";
    /**
     * If id is supplied, calls store method for every row.
     * @param int $id Id of main-model this model is created for.
     * @return bool Storing was successful.
     */
    public function store(int $id = 0) : bool {
        error_log("ID SEKV JE>".$id);
        if (!$id) return false;
        $idx = 0;
        foreach ($this->items as $item) {
            if(!$item->store($id, ++$idx)) return false;
        }
        return true;
    }

    protected function storeCommit() : void {
        parent::storeCommit(); // TODO: Change the autogenerated stub
        foreach ($this->items as $item) $item->storeCommit();
    }


    /**
     * Removes one specific row from the table.
     * @param MRTR<type> $itemModel Model of the deleted row.
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
        $class = static::RowModelClass;
        $this->items[] = new $class();
    }
}