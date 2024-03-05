<?php

class VFormFieldButtonSubmit extends VFormFieldButton {
    const ButtonType = "submit";

    public function __construct(&$model, $viewContent, $label = NULL) {
        parent::__construct($model, "clickedSubmit", $viewContent, $label);
    }
}