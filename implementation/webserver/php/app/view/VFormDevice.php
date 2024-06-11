<?php

class VFormDevice extends VForm {
    const FormId = "editDevice";
    const ModelClass = MDevice::class;

    public function __construct($deviceId) {
        parent::__construct($deviceId);
        $canEdit = (isset($_SESSION["perms"]->getDomainsByPerm("can_edit_devices")[$this->model->domainId]) || $_SESSION["perms"]->canEditAll());
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VFormFieldText($this->model->location, "Physical Location"))->disable(!$canEdit));
        $this->add((new VFfDdDeviceGateways($this->model->gatewayId, "Gateway"))->disable(!$canEdit));
        //$this->add(new VFormFieldDateTime($this->model->lastChanged, "last changed DEMO")); // TODO: remove this
        $this->add((new VRTCollInDevice($this->model->collections, "Collections"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}