<?php

class VTableHeading extends VList {
    public function __construct($columns, $makeRemoveCol = false) {
        foreach ($columns as $col) {
            $this->add(new VText($col));
        }
        if ($makeRemoveCol) $this->add(new VText("remove"));
    }

    protected function renderItem(VView $v) {
        echo "<th>";
        parent::renderItem($v);
        echo "</th>\n";
    }


}