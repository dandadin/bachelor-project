<?php

class VPage extends VPageHollow {

    public function __construct() {
        // TODO: login logika
        $this->add(new VMenuBarUser());
        parent::__construct();
    }
}