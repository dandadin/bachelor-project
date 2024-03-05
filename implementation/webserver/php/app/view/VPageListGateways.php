<?php

class VPageListGateways extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VGatewayList());
        $this->add(new VLink("add new", "/edit.php?type=ga&id=0"));
    }

}