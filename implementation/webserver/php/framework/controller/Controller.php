<?php

abstract class Controller {
    protected $formField;
    protected $model;

    public function __construct(&$model, $formField) {
        $this->model = &$model;
        $this->formField = $formField;
    }

    public abstract function update();
}