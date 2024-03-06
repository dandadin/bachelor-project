<?php

class VRelTabRow extends VList {

    public function __construct(&$model) {
        $this->add(new VFormFieldButton($model, "delete", new VIcon("/icon/delete.png", "delete this record")));
    }

    protected function renderItem(VView $v) {
        echo "<td>";
        parent::renderItem($v); // TODO: Change the autogenerated stub
        echo "</td>";
    }


}