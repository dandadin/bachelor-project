<?php

class VRelTableHeading extends VList {
    public function __construct($columns) {
        foreach ($columns as $col) {
            $this->add(new VText($col));
        }
        $this->add(new VText("remove"));
    }

    protected function renderItem(VView $v) {
        echo "<th>";
        parent::renderItem($v);
        echo "</th>";
    }


}