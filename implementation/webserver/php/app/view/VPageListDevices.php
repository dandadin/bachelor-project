<?php

class VPageListDevices extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Devices</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Location", "Gateway", "Created At", "Last Changed At"], "SELECT devices.*, g.name AS gname FROM devices LEFT JOIN gateways g on devices.gateway_id = g.id", VPTRDevice::class));
        $this->add(new VLink(new VText("Add New"), "/edit.php?type=de&id=0", "button-link"));
    }

}