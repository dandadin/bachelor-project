<?php

class VPageLogin extends VPageHollow {
    protected const Title = "Login";
    protected const Header = "<link rel=\"stylesheet\" href=\"/css/login.css\"/>";

    public function __construct() {
        parent::__construct();
        if(isset($_SESSION["loginId"])) {header("Location: /"); exit();}
        else {
            $this->add(new VText("<h1>IoTHome</h1>"));
            $this->add(new VFormLogin());
        }
    }
}