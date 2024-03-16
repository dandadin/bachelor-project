<?php

class CPageId extends Controller {

    public function __construct($formField) {
        $this->formField = $formField;
        $this->model = null;
    }


    public function update() {
        if(isset($_POST[$this->formField])) MObjectModel::setPageId(intval($_POST[$this->formField]));
    }

}