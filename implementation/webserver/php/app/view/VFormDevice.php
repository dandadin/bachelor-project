<?php

class VFormDevice extends VForm {
    const FormId = "editDevice";
    const ModelClass = MDevice::class;

    public function __construct($deviceId) {
        parent::__construct($deviceId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFormFieldText($this->model->location, "Physical Location"));
        $this->add(new VFfDdDeviceGateways($this->model->gatewayId, "Gateway"));
        $this->add(new VFormFieldDateTime($this->model->lastChanged, "last changed DEMO")); // TODO: remove this
        $this->add(new VRTCollInDevice($this->model->collections, "Collections"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}