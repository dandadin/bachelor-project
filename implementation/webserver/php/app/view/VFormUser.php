<?php

class VFormUser extends VForm {
    const FormId = "editUser";
    const ModelClass = MUser::class;

    public function __construct($userId) {
        parent::__construct($userId);
        $this->add(new VFormFieldText($this->model->login, "Username"));
        $this->add(new VFormFieldPassword($this->model->pwdHash, "Password"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""));
    }



}