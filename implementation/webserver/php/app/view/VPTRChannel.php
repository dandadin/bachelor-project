<?php

/**
 * View for table row that renders info about channel.
 */
class VPTRChannel extends VPTableRow {

    /**
     * Constructs row of table, that shows info about channel.
     * @param $o Row from database with data about one channel.
     */
    public function __construct($o) {
        $this->add(new VText($o->id));
        $this->add(new VLink(new VText($o->name), "/edit.php?type=ch&id=$o->id"));
        $this->add(new VLink(new VText($o->dname), "/edit.php?type=de&id=$o->device_id"));
        $this->add(new VText($o->comm_type));
        $this->add(new VText($o->value_type));
        $this->add(new VText($o->update_freq));
        parent::__construct("/delete.php?type=ch&id=$o->id");
    }
}