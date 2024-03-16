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
        $this->add(new VLink(new VText($o->id), "/plan/$o->id/edit"));
        $this->add(new VLink(new VText($o->sname), "/sequence/$o->seq_id/edit"));
        $this->add(new VText($o->period));
        $this->add(new VText($o->offset));
        $this->add(new VText($o->last_ts));
        parent::__construct("/plan/$o->id/delete");
    }
}