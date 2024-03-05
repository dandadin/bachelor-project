<?php

class VFormGateway extends VForm {
    const FormId = "editGateway";
    const ModelClass = MGateway::class;

    public function __construct($gwId) {
        parent::__construct($gwId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFormFieldText($this->model->address, "address"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}