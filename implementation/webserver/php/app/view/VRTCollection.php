<?php

class VRTCollection extends VRelTable {
    const Heading = ["Collection"];
    const RowClass = VRTRCollection::class;

    public function __construct(&$model, $label = NULL) {
        parent::__construct($model, $label);
    }


}