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
        $this->add(new VLink(new VText($o->name), "/sequence/$o->id/edit"));
        parent::__construct("/sequence/$o->id/delete");
    }
}