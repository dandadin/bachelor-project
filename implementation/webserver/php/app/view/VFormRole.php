<?php

class VFormRole extends VForm {
    const FormId = "editRole";
    const ModelClass = MRole::class;

    public function __construct($roleId) {
        parent::__construct($roleId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFormFieldBoolean($this->model->canEditGroups, "Can Edit Groups?"));
        $this->add(new VFormFieldBoolean($this->model->canEditUsers, "Can Edit Users?"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}