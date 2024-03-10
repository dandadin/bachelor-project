<?php

/**
 * View for table row that renders info about device.
 */
class VPTRDevice extends VPTableRow {

    /**
     * Constructs row of table, that shows info about device.
     * @param $o Row from database with data about one device.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=de&id=$o->id"));
        $this->add(new VText($o->location));
        $this->add(new VLink(new VText($o->gname), "/edit.php?type=ga&id=$o->gateway_id"));
        $this->add(new VText($o->created));
        $this->add(new VText($o->last_changed));
        parent::__construct("/delete.php?type=de&id=$o->id");
    }
}