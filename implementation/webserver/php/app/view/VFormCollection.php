<?php

class VFormCollection extends VForm {
    const FormId = "editCollection";
    const ModelClass = MCollection::class;

    public function __construct($collId) {
        parent::__construct($collId);
        $this->add(new VFormFieldText($this->model->name, "Name"));
        $this->add(new VFfDdCollectionDomains($this->model->domainId, "Domain"));
        $this->add(new VRTUserInColl($this->model->users, "Users"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}