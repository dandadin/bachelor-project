<?php

class VPageListDevices extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VDeviceList());
        $this->add(new VLink("add new", "/edit.php?type=de&id=0"));
    }

}