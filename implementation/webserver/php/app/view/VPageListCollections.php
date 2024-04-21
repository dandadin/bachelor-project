<?php

class VPageListCollections extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Collections</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Domain"],
            "SELECT collections.*, d.name AS dname FROM collections LEFT JOIN domains d on d.id = collections.domain_id".
            ($_SESSION["perms"]->canEditAll() ? "" : " WHERE d.id IN "
            .PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_list_colls"))),
            VPTRCollection::class));
        $this->add(new VLink(new VText("Add New"), "/collection/new", "button-link"));
    }

}