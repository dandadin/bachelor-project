<?php

/**
 * View for table row that renders info about instance.
 */
class VPTRInstance extends VPTableRow {

    /**
     * Constructs row of table, that shows info about instance.
     * @param $o Row from database with data about one instance.
     */
    public function __construct($o) {
        $this->add(new VLink(new VText($o->id), "/instance/$o->id/edit"));
        $this->add(new VLink(new VText($o->sname), "/sequence/$o->seq_id/edit"));
        $this->add(new VLink(new VText($o->step_id), "/step/$o->step_id/edit"));
        $this->add(new VText($o->step_ts));
        parent::__construct("/instance/$o->id/delete");
    }
}