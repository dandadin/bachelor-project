<?php

class VFormCollection extends VForm {
    const FormId = "editCollection";
    const ModelClass = MCollection::class;

    public function __construct($collId) {
        parent::__construct($collId);
        $this->add(new VFormFieldText($this->model->name, "name"));
        $this->add(new VFfDdCollectionDomains($this->model->domainId, "domain"));
        $this->add(new VRTUser($this->model->users, "users"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}