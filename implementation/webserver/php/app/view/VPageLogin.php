<?php

class VPageLogin extends VPageHollow {
    protected const Title = "Login";

    public function __construct() {
        parent::__construct();
        if(isset($_SESSION["loginId"])) $this->add(new VPageHome());
        else $this->add(new VFormLogin());
    }
}