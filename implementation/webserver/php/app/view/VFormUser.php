<?php

class VFormUser extends VForm {
    const FormId = "editUser";
    const ModelClass = MUser::class;

    public function __construct($userId) {
        parent::__construct($userId);
        $canEdit = ($_SESSION["perms"]->canEditAll()) || $_SESSION["loginId"] == $userId;
        $this->add((new VFormFieldText($this->model->login, "Username"))->disable(!$canEdit));
        $this->add((new VFormFieldPassword($this->model->pwdHash, "Password"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}