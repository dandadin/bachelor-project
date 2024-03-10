<?php

/**
 * View for table row that renders info about role.
 */
class VPTRRole extends VPTableRow {

    /**
     * Constructs row of table, that shows info about role.
     * @param $o Row from database with data about one role.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=ro&id=$o->id"));
        $this->add(new VText($o->can_edit_groups ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_users ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        parent::__construct("/delete.php?type=ro&id=$o->id");
    }
}