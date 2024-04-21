<?php

class VPageListUsers extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Users</h1>"));
        $this->add(new VPlainTable(["ID", "Username"],
            "SELECT * FROM users".
            ($_SESSION["perms"]->canEditAll() ? "" :
                " WHERE id IN (SELECT domain_users.user_id FROM domain_users WHERE domain_id IN "
                .PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_list_users")).")"),
            VPTRUser::class));
        $this->add(new VLink(new VText("Add New"), "/user/new", "button-link"));
    }
}