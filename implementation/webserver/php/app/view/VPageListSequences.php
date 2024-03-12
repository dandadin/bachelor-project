<?php

class VPageListSequences extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Sequences</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "First Step's Channel Name"], "SELECT sequences.*, c.name AS cname, c.id AS cid FROM sequences LEFT JOIN steps s on s.id = sequences.first_step_id LEFT JOIN channels c on s.channel_id = c.id", VPTRSequence::class));
        $this->add(new VLink(new VText("Add New"), "/edit.php?type=se&id=0", "button-link"));
    }
}