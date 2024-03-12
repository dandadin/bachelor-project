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
        $this->add(new VLink(new VText($o->id), "/edit.php?type=in&id=$o->id"));
        $this->add(new VLink(new VText($o->sname), "/edit.php?type=se&id=$o->seq_id"));
        $this->add(new VLink(new VText($o->step_id), "/edit.php?type=st&id=$o->step_id"));
        $this->add(new VText($o->step_ts));
        parent::__construct("/delete.php?type=in&id=$o->id");
    }
}