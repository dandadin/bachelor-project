<?php

class CButton extends Controller {
    protected $method;
    protected $argument;

    public function __construct(MModel &$model, $formField, $method, $argument = null) {
        parent::__construct($model, $formField);
        $this->method = $method;
        $this->argument = $argument;
    }


    public function update() {
        $m = $this->method;
        if(isset($_POST[$this->formField])) $this->model->$m($this->argument);
    }
}