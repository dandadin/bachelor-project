<?php

class VFormInstance extends VForm {
    const FormId = "editInstance";
    const ModelClass = MInstance::class;

    public function __construct($instanceId) {
        parent::__construct($instanceId);
        $this->add(new VFormFieldNumber($this->model->seqId, "Sequence"));
        $this->add(new VFormFieldNumber($this->model->stepId, "Step"));
        $this->add(new VFormFieldDateTime($this->model->stepTs, "step ts DEMO")); // TODO: remove this
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}