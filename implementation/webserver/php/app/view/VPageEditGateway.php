<?php

class VPageEditGateway extends VPage {
    public function __construct($gwId) {
        parent::__construct();
        $this->add(new VFormGateway($gwId));
    }

}