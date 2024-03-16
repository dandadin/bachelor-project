<?php

/**
 * Class for keeping models (and other data) of single form between page loads.
 */
class FormContext {
    /**
     * @var MObjectModel $model
     * Model of specific form.
     */
    public MObjectModel $model;
    /**
     * @var array $controllerCollection
     * Array of controllers of fields in a specific form.
     */
    public $controllerCollection = array();
    /**
     * @var array $modelCollection
     * Array of all models for all forms, indexed by formId.
     */
    private static $modelCollection = array();

    public function __construct(&$model) {
        $this->model = &$model;
    }

    public function store($formId) {
        PageContext::getPageContext(MObjectModel::getPageId())->add($formId, serialize($this));
    }

    /**
     * Calls update method for every controller of this form.
     * The controllers load new data from $_POST and save it to $this->>model.
     * @return MObjectModel Updated model of this form.
     */
    public function updateModel() : MObjectModel {
        foreach ($this->controllerCollection as $c) $c->update();
        return $this->model;
    }

    /**
     * Returns model for specific form, defined by $formId.
     * @param string $formId Id of specific form we want the model of.
     * @return MObjectModel|null Model of specific form, null if model not found.
     */
    public static function getFormModel(string $formId) : MObjectModel|null {
        return static::$modelCollection[$formId] ?? null;
    }

    /**
     * Saves model of specific form, identified by $formId.
     * @param string $formId Id of form.
     * @param MObjectModel $model Model of form.
     * @return void
     */
    public static function setFormModel(string $formId, MObjectModel $model) {
        static::$modelCollection[$formId] = $model;
    }

    /**
     * Registers new controller of formfield to specific form.
     * @param Controller $c Controller of the field.
     * @return void
     */
    public function add(Controller $c) {
        $this->controllerCollection[] = $c;
    }
}