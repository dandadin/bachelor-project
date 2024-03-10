<?php

/**
 * View for table row that renders info about user.
 */
class VPTRUser extends VPTableRow {

    /**
     * Constructs row of table, that shows info about user.
     * @param $o Row from database with data about one user.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->login), "/edit.php?type=us&id=$o->id"));
        parent::__construct("/delete.php?type=us&id=$o->id");
    }
}