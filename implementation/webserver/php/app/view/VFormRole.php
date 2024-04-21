<?php

class VFormRole extends VForm {
    const FormId = "editRole";
    const ModelClass = MRole::class;

    public function __construct($roleId) {
        parent::__construct($roleId);
        $canEdit = ($_SESSION["perms"]->canEditAll());
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canListColls, "Can List Collections?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canEditColls, "Can Edit Collections?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canListUsers, "Can List Users?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canEditUsers, "Can Edit Users?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canListDevices, "Can List Devices?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canEditDevices, "Can Edit Devices?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canListGateways, "Can List Gateways?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canEditGateways, "Can Edit Gateways?"))->disable(!$canEdit));
        $this->add((new VFormFieldBoolean($this->model->canEditAll, "Can Edit All?"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}