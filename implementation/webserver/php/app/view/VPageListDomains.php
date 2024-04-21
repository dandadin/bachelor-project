<?php

class VPageListDomains extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Domains</h1>"));
        $this->add(new VPlainTable(["ID", "Name"],
            "SELECT * FROM domains".
            ($_SESSION["perms"]->canEditAll() ? "" :
                (" WHERE domains.id IN ".PermissionManager::arrayToSQL($_SESSION["perms"]->getAllDomains()))),
            VPTRDomain::class));
        $this->add(new VLink(new VText("Add New"), "/domain/new", "button-link"));
    }

}