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
        $this->add(new VLink(new VText($o->name), "/role/$o->id/edit"));
        $this->add(new VText($o->can_list_colls ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_colls ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_list_users ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_users ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_list_devices ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_devices ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_list_gateways ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_gateways ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        $this->add(new VText($o->can_edit_all ? "<span data-tag='Yes'>Yes</span>" : "<span data-tag='No'>No</span>"));
        parent::__construct($_SESSION["perms"]->canEditAll() ? "/role/$o->id/delete" : null);
    }
}