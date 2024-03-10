<?php

/**
 * View for table row that renders info about gateway.
 */
class VPTRGateway extends VPTableRow {

    /**
     * Constructs row of table, that shows info about gateway.
     * @param $o Row from database with data about one gateway.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=ga&id=$o->id"));
        $this->add(new VText($o->address));
        parent::__construct("/delete.php?type=ga&id=$o->id");
    }
}