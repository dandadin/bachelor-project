<?php

class VTableHeading extends VList {
    public function __construct($columns, $makeRemoveCol = "") {
        foreach ($columns as $col) {
            $this->add(new VText($col));
        }
        if ($makeRemoveCol) $this->add(new VText($makeRemoveCol));
    }

    protected function renderItem(VView $v): void {
        echo "<th>";
        parent::renderItem($v);
        echo "</th>\n";
    }


}