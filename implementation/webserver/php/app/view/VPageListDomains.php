<?php

class VPageListDomains extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Domains</h1>"));
        $this->add(new VPlainTable(["ID", "Name"], "SELECT * FROM domains", VPTRDomain::class));
        $this->add(new VLink(new VText("Add New"), "/edit.php?type=do&id=0", "button-link"));
    }

}