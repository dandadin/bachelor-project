<?php

/**
 * View for table-row of relative table rendering users.
 */
class VRTRUserRoleInDom extends VRelTabRow {

    /**
     * Constructs views for every cell and adds it to the table.
     * @param $itemModel Should be an instance of MRTR<type> containing data of this row.
     * @param $tableModel Should be an instance of MRelTable<type> this row is created for.
     */
    public function __construct(&$itemModel, &$tableModel) {
        $sqls=DB::query("SELECT * FROM users WHERE id=$itemModel->userId");
        $o=$sqls->fetchObject();
        if ($o) {
            $this->add(new VText($o->login));
        } else {
            $itemModel->userId = 0;
            $this->add(new VFormFieldText($itemModel->login));
        }

        $sqls=DB::query("SELECT * FROM roles WHERE id=$itemModel->roleId");
        $o=$sqls->fetchObject();
        if ($o) {
            $this->add(new VText($o->name));
        } else $this->add(new VFfDdRole($itemModel->roleId));

        parent::__construct($itemModel, $tableModel);
    }
}