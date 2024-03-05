<?php

class VPage extends VPageHollow {

    public function __construct() {
        parent::__construct();
        // TODO: login logika
        $this->add(new VMenuBarUser());
    }
}