<?php

class VPageEditInstance extends VPage {
    public function __construct($instanceId) {
        parent::__construct();
        $this->add(new VFormInstance($instanceId));
    }

}