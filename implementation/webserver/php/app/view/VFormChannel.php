<?php

class VFormChannel extends VForm {
    const FormId = "editChannel";
    const ModelClass = MChannel::class;

    public function __construct($channelId) {
        parent::__construct($channelId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFfDdChannelDevices($this->model->deviceId, "Device"));
        $this->add(new VFormFieldNumber($this->model->commType, "Communication Type"));
        $this->add(new VFormFieldNumber($this->model->valueType, "Value Type"));
        $this->add(new VFormFieldNumber($this->model->updateFreq, "Update Frequency"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}