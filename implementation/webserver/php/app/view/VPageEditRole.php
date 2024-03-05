<?php

class VPageEditRole extends VPage {
    public function __construct($roleId) {
        parent::__construct();
        $this->add(new VFormRole($roleId));
    }

}