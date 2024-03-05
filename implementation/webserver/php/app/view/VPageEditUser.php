<?php

class VPageEditUser extends VPage {
    public function __construct($userId) {
        parent::__construct();
        $this->add(new VFormUser($userId));
    }

}