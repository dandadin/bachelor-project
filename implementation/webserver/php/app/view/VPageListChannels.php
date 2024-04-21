<?php

class VPageListChannels extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Channels</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Device", "Communication Type", "Value Type", "Update Frequency [s]"],
            "SELECT channels.*, d.name AS dname, d.domain_id AS domid FROM channels LEFT JOIN devices d on d.id = channels.device_id".
            ($_SESSION["perms"]->canEditAll() ? "" :
            " WHERE d.domain_id IN ".
            PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_list_devices"))),
            VPTRChannel::class));
        $this->add(new VLink(new VText("Add New"), "/channel/new", "button-link"));
    }
}