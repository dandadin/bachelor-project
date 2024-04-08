<?php

class VFormGateway extends VForm {
    const FormId = "editGateway";
    const ModelClass = MGateway::class;

    public function __construct($gwId) {
        parent::__construct($gwId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFormFieldText($this->model->address, "Address"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
        $this->add(new VFormFieldButtonLoad($this->model, new VText("Load Config"), ""));
        $this->add(new VJsonTable(["Device Name", "Location", "Channels"], ($this->model->config ? $this->model->config["devices"] : null), VPTRGatewayJson::class));
    }



}