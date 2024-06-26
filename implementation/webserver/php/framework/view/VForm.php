<?php

abstract class VForm extends VList {
    const FormId = "";
    const ModelClass = "";
    protected $formId;
    protected $model;

    public function __construct($modelArg) {
        $this->formId = static::FormId;
        $this->model = FormContext::getFormModel($this->formId);
        $class = static::ModelClass;
        if(!$this->model) $this->model = new $class($modelArg);
        $this->add(new VPageId());
    }

    public function render(): void {
        parent::render(); // TODO: Change the autogenerated stub
        $this->storeContext();
    }


    public function renderHeader(): void {
        parent::renderHeader(); // TODO: Change the autogenerated stub
        echo "<form method='post' name='$this->formId'>\n";
        echo "<input type='hidden' name='formId' value='$this->formId'/>\n";
    }

    public function renderFooter(): void {
        echo "</form>\n";
        parent::renderFooter(); // TODO: Change the autogenerated stub
    }

    private function storeContext() {
        $c = new FormContext($this->model);
        $this->registerController($c);
        $c->store($this->formId);
    }
}