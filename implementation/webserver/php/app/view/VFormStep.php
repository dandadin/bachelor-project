<?php

class VFormStep extends VForm {
    const FormId = "editStep";
    const ModelClass = MStep::class;

    public function __construct($stepId) {
        parent::__construct($stepId);
        $this->add(new VFormFieldNumber($this->model->nextStepId, "Next Step"));
        $this->add(new VFormFieldNumber($this->model->channelId, "Channel"));
        $this->add(new VFormFieldText($this->model->value, "Value"));
        $this->add(new VFormFieldNumber($this->model->delayBefore, "Delay Before"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}