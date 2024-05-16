<?php

/**
 * View for table row that renders info about channel.
 */
class VPTRChannel extends VPTableRow {

    /**
     * Constructs row of table, that shows info about channel.
     * @param $o Row from database with data about one channel.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/channel/$o->id/edit"));
        $this->add(new VLink(new VText($o->dname), "/device/$o->device_id/edit"));
        $this->add(new VText($o->comm_type));
        $this->add(new VText($o->value_type));
        $this->add(new VText($o->update_freq));
        parent::__construct( ($_SESSION["perms"]->checkDomainPerm($o->domid, "can_edit_devices") || $_SESSION["perms"]->canEditAll()) ? "/channel/$o->id/delete" : null);
    }
}