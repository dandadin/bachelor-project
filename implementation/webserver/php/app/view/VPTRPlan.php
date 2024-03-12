<?php

/**
 * View for table row that renders info about plan.
 */
class VPTRPlan extends VPTableRow {

    /**
     * Constructs row of table, that shows info about plan.
     * @param $o Row from database with data about one plan.
     */
    public function __construct($o) {
        $this->add(new VLink(new VText($o->id), "/edit.php?type=pl&id=$o->id"));
        $this->add(new VLink(new VText($o->sname), "/edit.php?type=se&id=$o->seq_id"));
        $this->add(new VText($o->period));
        $this->add(new VText($o->offset));
        $this->add(new VText($o->last_ts));
        parent::__construct("/delete.php?type=pl&id=$o->id");
    }
}