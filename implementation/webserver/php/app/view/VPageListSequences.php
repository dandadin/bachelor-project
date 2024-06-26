<?php

class VPageListSequences extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Sequences</h1>"));
        $this->add(new VPlainTable(["ID", "Name"], "SELECT sequences.* FROM sequences".
            ($_SESSION["perms"]->canEditAll() ? "" : " WHERE user_id=".$_SESSION["loginId"]),
            VPTRSequence::class));
        $this->add(new VLink(new VText("Add New"), "/sequence/new", "button-link"));
    }
}