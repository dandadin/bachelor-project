<?php

class VPageListRoles extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VRoleList());
        $this->add(new VLink("add new", "/edit.php?type=ro&id=0"));
    }

}