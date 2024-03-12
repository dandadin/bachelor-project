<?php

/**
 * View for table row that renders info about step.
 */
class VPTRStep extends VPTableRow {

    /**
     * Constructs row of table, that shows info about step.
     * @param $o Row from database with data about one step.
     */
    public function __construct($o) {
        $this->add(new VLink(new VText($o->id), "/edit.php?type=st&id=$o->id"));
        $this->add(new VLink(new VText($o->cname), "/edit.php?type=ch&id=$o->channel_id"));
        $this->add(new VText($o->value));
        $this->add(new VText($o->delay_before));
        $this->add(new VText($o->next_step_id));
        parent::__construct("/delete.php?type=st&id=$o->id");
    }
}