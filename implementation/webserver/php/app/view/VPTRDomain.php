<?php

/**
 * View for table row that renders info about domain.
 */
class VPTRDomain extends VPTableRow {

    /**
     * Constructs row of table, that shows info about domain.
     * @param $o Row from database with data about one domain.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/domain/$o->id/edit"));
        parent::__construct($_SESSION["perms"]->canEditAll() ? "/domain/$o->id/delete" : null);
    }
}