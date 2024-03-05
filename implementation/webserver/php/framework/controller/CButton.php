<?php

class CButton extends Controller {
    protected $method;

    public function __construct(MModel &$model, $formField, $method) {
        parent::__construct($model, $formField);
        $this->method = $method;
    }


    public function update() {
        $m = $this->method;
        if(isset($_POST[$this->formField])) $this->model->$m();
    }
}