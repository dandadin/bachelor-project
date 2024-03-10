<?php

class VPageListGateways extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Gateways</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Address"], "SELECT * FROM gateways", VPTRGateway::class));
        $this->add(new VLink(new VText("add new"), "/edit.php?type=ga&id=0"));
    }

}