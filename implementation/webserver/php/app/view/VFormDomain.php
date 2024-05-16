<?php

class VFormDomain extends VForm {
    const FormId = "editDomain";
    const ModelClass = MDomain::class;

    public function __construct($domainId) {
        parent::__construct($domainId);
        $canEdit = ($_SESSION["perms"]->canEditAll());
        $canEditUsers = (isset($_SESSION["perms"]->getDomainsByPerm("can_edit_users")[$domainId]) || $_SESSION["perms"]->canEditAll()   );
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VRTUserRoleInDom($this->model->userroles, "Users and Roles"))->disable(!$canEditUsers));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit && !$canEditUsers));
    }



}