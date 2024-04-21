<?php

class VFormSequence extends VForm {
    const FormId = "editSequence";
    const ModelClass = MSequence::class;

    public function __construct($sequenceId) {
        parent::__construct($sequenceId);
        $canEdit = ($_SESSION["loginId"]==$this->model->userId);
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VRTStepsInSequence($this->model->steps, "Steps"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}