<?php

/**
 * View for table row that renders info about step.
 */
class VPTRStep extends VPTableRow {

    /**
     * Constructs row of table, that shows info about step.
     * @param $o Row from database with data about one step.
     */
    public function __construct($o) {
        $this->add(new VLink(new VText($o->id), "/step/$o->id/edit"));
        $this->add(new VLink(new VText($o->sname), "/sequence/$o->seq_id/edit"));
        $this->add(new VText($o->idx));
        $this->add(new VLink(new VText($o->cname), "/channel/$o->channel_id/edit"));
        $this->add(new VText($o->value));
        $this->add(new VText($o->delay_before));
        parent::__construct("/step/$o->id/delete");
    }
}