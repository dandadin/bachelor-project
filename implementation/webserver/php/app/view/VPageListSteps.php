<?php

class VPageListSteps extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Steps</h1>"));
        $this->add(new VPlainTable(["ID", "Step's Sequence", "Index In Sequence", "Step's Channel", "Value", "Delay Before"], "SELECT steps.*, c.name AS cname, s.name AS sname FROM steps LEFT JOIN channels c on steps.channel_id = c.id LEFT JOIN sequences s on steps.seq_id=s.id", VPTRStep::class));
        $this->add(new VLink(new VText("Add New"), "/step/0", "button-link"));
    }
}