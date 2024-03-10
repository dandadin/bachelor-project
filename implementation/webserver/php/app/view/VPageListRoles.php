<?php

class VPageListRoles extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Roles</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Can Edit Groups", "Can Edit Users"], "SELECT * FROM roles", VPTRRole::class));
        $this->add(new VLink(new VText("add new"), "/edit.php?type=ro&id=0"));
    }

}