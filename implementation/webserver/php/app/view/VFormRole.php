<?php

class VFormRole extends VForm {
    const FormId = "editRole";
    const ModelClass = MRole::class;

    public function __construct($roleId) {
        parent::__construct($roleId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFormFieldBoolean($this->model->canEditColls, "Can Edit Collections?"));
        $this->add(new VFormFieldBoolean($this->model->canEditUsers, "Can Edit Users?"));
        $this->add(new VFormFieldBoolean($this->model->canEditDevices, "Can Edit Devices?"));
        $this->add(new VFormFieldBoolean($this->model->canEditGateways, "Can Edit Gateways?"));
        $this->add(new VFormFieldBoolean($this->model->canEditAll, "Can Edit All?"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}