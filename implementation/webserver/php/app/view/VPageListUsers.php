<?php

class VPageListUsers extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Users</h1>"));
        $this->add(new VPlainTable(["ID", "Username"], "SELECT * FROM users", VPTRUser::class));
        $this->add(new VLink(new VText("Add New"), "/user/new", "button-link"));
    }
}