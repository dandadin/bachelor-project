<?php

class VFormGateway extends VForm {
    const FormId = "editGateway";
    const ModelClass = MGateway::class;

    public function __construct($gwId) {
        parent::__construct($gwId);
        $canEdit = ($_SESSION["perms"]->canEditAll());
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VFormFieldText($this->model->address, "Address"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
        $this->add((new VFormFieldButtonLoad($this->model, new VText("Load Config"), ""))->disable(!$canEdit));
        $this->add((new VJsonTable(["Device Name", "Location", "Channels"], ($this->model->config ? $this->model->config["devices"] : null), VPTRGatewayJson::class))->disable(!$canEdit));
    }



}