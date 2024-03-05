<?php

class VPageListDomains extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VDomainList());
        $this->add(new VLink("add new", "/edit.php?type=do&id=0"));
    }

}