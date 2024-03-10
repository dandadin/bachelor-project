<?php

class VPageLogout extends VPageHollow {
    protected const Title = "Logout";

    public function __construct() {
        parent::__construct();
        $m = new MLogin();
        $m->delete();

        $this->add(new VText("You have been logged out."));
        $this->add(new VLink(new VText("login"), "/login.php"));
    }


}