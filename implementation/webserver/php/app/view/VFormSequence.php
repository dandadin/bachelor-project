<?php

class VFormSequence extends VForm {
    const FormId = "editSequence";
    const ModelClass = MSequence::class;

    public function __construct($sequenceId) {
        parent::__construct($sequenceId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VRTStepsInSequence($this->model->steps, "Steps"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}