<?php

class VFormUser extends VForm {
    const FormId = "editUser";
    const ModelClass = MUser::class;

    public function __construct($userId) {
        parent::__construct($userId);
        $this->add(new VFormFieldText($this->model->login, "username"));
        $this->add(new VFormFieldPassword($this->model->pwdHash, "password"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Odesli!"), "odesilaci buttonek"));
    }



}