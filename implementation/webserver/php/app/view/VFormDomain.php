<?php

class VFormDomain extends VForm {
    const FormId = "editDomain";
    const ModelClass = MDomain::class;

    public function __construct($domainId) {
        parent::__construct($domainId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}