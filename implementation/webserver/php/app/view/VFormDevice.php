<?php

class VFormDevice extends VForm {
    const FormId = "editDevice";
    const ModelClass = MDevice::class;

    public function __construct($deviceId) {
        parent::__construct($deviceId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFormFieldText($this->model->location, "location"));
        $this->add(new VFfDdDeviceGateways($this->model->gatewayId, "gateway"));
        $this->add(new VFormFieldDateTime($this->model->lastChanged, "last changed DEMO")); // TODO: remove this
        $this->add(new VRTCollection($this->model->collections, "collections"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}