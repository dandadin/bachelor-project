<?php

class VFormSequence extends VForm {
    const FormId = "editSequence";
    const ModelClass = MSequence::class;

    public function __construct($sequenceId) {
        parent::__construct($sequenceId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFfDdSequenceSteps($this->model->firstStepId, "First Step"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}