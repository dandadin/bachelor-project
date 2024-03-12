<?php

class VPageListSteps extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Steps</h1>"));
        $this->add(new VPlainTable(["ID", "Step's Channel Name", "Value", "Delay Before", "Next Step ID"], "SELECT steps.*, c.name AS cname FROM steps LEFT JOIN channels c on steps.channel_id = c.id", VPTRStep::class));
        $this->add(new VLink(new VText("Add New"), "/edit.php?type=st&id=0", "button-link"));
    }
}