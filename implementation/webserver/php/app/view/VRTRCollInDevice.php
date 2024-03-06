<?php

/**
 * View for table-row of relative table rendering collections.
 */
class VRTRCollInDevice extends VRelTabRow {

    /**
     * Constructs views for every cell and adds it to the table.
     * @param $itemModel Should be an instance of MRTR<type> containing data of this row.
     * @param $tableModel Should be an instance of MRelTable<type> this row is created for.
     */
    public function __construct(&$itemModel, &$tableModel) {
        $sqls=DB::query("SELECT * FROM collections WHERE id=$itemModel->collId");
        $o=$sqls->fetchObject();
        if ($o) {
            $this->add(new VText($o->name));
        } else $this->add(new VFfDdCollection($itemModel->collId));
        parent::__construct($itemModel, $tableModel);
    }
}