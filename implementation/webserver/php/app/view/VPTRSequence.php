<?php

/**
 * View for table row that renders info about sequence.
 */
class VPTRSequence extends VPTableRow {

    /**
     * Constructs row of table, that shows info about sequence.
     * @param $o Row from database with data about one sequence.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=se&id=$o->id"));
        $this->add(new VLink(new VText($o->cname), "/edit.php?type=ch&id=$o->cid"));
        parent::__construct("/delete.php?type=se&id=$o->id");
    }
}