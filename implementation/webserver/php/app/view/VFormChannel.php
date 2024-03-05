<?php

class VFormChannel extends VForm {
    const FormId = "editChannel";
    const ModelClass = MChannel::class;

    public function __construct($channelId) {
        parent::__construct($channelId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFfDdChannelDevices($this->model->deviceId, "device"));
        $this->add(new VFormFieldNumber($this->model->commType, "communication type"));
        $this->add(new VFormFieldNumber($this->model->valueType, "value type"));
        $this->add(new VFormFieldNumber($this->model->updateFreq, "update frequency"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}