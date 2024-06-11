<?php

/**
 * View for table row that renders info about device.
 */
class VPTRDevice extends VPTableRow {

    /**
     * Constructs row of table, that shows info about device.
     * @param $o Row from database with data about one device.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/device/$o->id/edit"));
        $this->add(new VText($o->location));
        $this->add(new VLink(new VText($o->gname), "/gateway/$o->gateway_id/edit"));
        $this->add(new VText(timetostr($o->dc)));
        $this->add(new VText(timetostr($o->dlc)));
        parent::__construct(($_SESSION["perms"]->checkDomainPerm($o->domain_id, "can_edit_devices") || $_SESSION["perms"]->canEditAll()) ? "/device/$o->id/delete" : null);
    }
}