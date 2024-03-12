<?php

class VFormPlan extends VForm {
    const FormId = "editPlan";
    const ModelClass = MPlan::class;

    public function __construct($planId) {
        parent::__construct($planId);
        $this->add(new VFormFieldNumber($this->model->seqId, "Sequence"));
        $this->add(new VFormFieldNumber($this->model->period, "Period"));
        $this->add(new VFormFieldNumber($this->model->offset, "Offset"));
        $this->add(new VFormFieldDateTime($this->model->lastTs, "last ts DEMO")); // TODO: remove this
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}