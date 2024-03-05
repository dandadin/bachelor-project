<?php

class VFormRole extends VForm {
    const FormId = "editRole";
    const ModelClass = MRole::class;

    public function __construct($roleId) {
        parent::__construct($roleId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFormFieldBoolean($this->model->canEditGroups, "can edit groups"));
        $this->add(new VFormFieldBoolean($this->model->canEditUsers, "can edit users"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}