<?php

class VPageListRoles extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Roles</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Can List Collections", "Can Edit Collections",
            "Can List Users", "Can Edit Users", "Can List Devices", "Can Edit Devices",
            "Can List Gateways", "Can Edit Gateways", "Can Edit All"],
            "SELECT * FROM roles", VPTRRole::class));
        $this->add(new VLink(new VText("Add New"), "/role/new", "button-link"));
    }

}