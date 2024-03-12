<?php

class VPageListPlans extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Plans</h1>"));
        $this->add(new VPlainTable(["ID", "Sequence Name", "Period", "Offset", "Last Started"], "SELECT plans.*, s.name AS sname FROM plans LEFT JOIN sequences s on plans.seq_id = s.id", VPTRPlan::class));
        $this->add(new VLink(new VText("Add New"), "/edit.php?type=pl&id=0", "button-link"));
    }
}