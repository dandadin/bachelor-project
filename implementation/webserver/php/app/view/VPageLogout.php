<?php

class VPageLogout extends VPageHollow {
    protected const Title = "Logout";
    protected const Header = "<link rel=\"stylesheet\" href=\"/css/login.css\"/>";

    public function __construct() {
        parent::__construct();
        $m = new MLogin();
        $m->unpersist();

        $this->add(new VText("<h1>You have been logged out.</h1>"));
        $this->add(new VLink(new VText("Log in!"), "/login.php"));
    }


}