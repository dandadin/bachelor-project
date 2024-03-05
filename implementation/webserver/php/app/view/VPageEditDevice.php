<?php

class VPageEditDevice extends VPage {
    public function __construct($deviceId) {
        parent::__construct();
        $this->add(new VFormDevice($deviceId));
    }

}