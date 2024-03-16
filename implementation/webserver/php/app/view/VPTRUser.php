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
        $this->add(new VLink(new VText($o->login), "/user/$o->id/edit"));
        parent::__construct("/user/$o->id/delete");
    }
}