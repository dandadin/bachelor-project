<?php

/**
 * View for table row that renders info about collection.
 */
class VPTRCollection extends VPTableRow {

    /**
     * Constructs row of table, that shows info about collection.
     * @param $o Row from database with data about one collection.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=co&id=$o->id"));
        $this->add(new VLink(new VText($o->dname), "/edit.php?type=do&id=$o->domain_id"));
        parent::__construct("/delete.php?type=co&id=$o->id");
    }
}