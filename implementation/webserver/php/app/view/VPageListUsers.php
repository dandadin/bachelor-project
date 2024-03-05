<?php

class VPageListUsers extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VUserList());
        $this->add(new VLink("add new", "/edit.php?type=us&id=0"));
    }

}