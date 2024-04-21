<?php

class VFormCollection extends VForm {
    const FormId = "editCollection";
    const ModelClass = MCollection::class;

    public function __construct($collId) {
        parent::__construct($collId);
        $canEdit = (isset($_SESSION["perms"]->getDomainsByPerm("can_edit_colls")[$this->model->domainId]) || $_SESSION["perms"]->canEditAll());
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VFfDdCollectionDomains($this->model->domainId, "Domain"))->disable(!$canEdit));
        $this->add((new VRTUserInColl($this->model->users, "Users"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}