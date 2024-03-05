<?php

class VFormLogin extends VForm {
    const FormId = "login";
    const ModelClass = MLogin::class;

    public function __construct() {
        parent::__construct(NULL);
        $this->add(new VFormFieldText($this->model->login, "username"));
        $this->add(new VFormFieldPassword($this->model->pwdHash, "password"));
        $this->add(new VFormFieldButtonSubmit($this->model, new VText("Log in!"), ""));
    }
}