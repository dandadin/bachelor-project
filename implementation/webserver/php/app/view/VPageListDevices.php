<?php

class VPageListDevices extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Devices</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Location", "Gateway", "Created At", "Last Changed At"],
            "SELECT devices.*, g.name AS gname FROM devices LEFT JOIN gateways g on devices.gateway_id = g.id".
            ($_SESSION["perms"]->canEditAll() ? "" :
                " WHERE domain_id IN "
            .PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_list_devices"))),
            VPTRDevice::class));
        $this->add(new VLink(new VText("Add New"), "/device/new", "button-link"));
    }

}