<?php

class VPageEditStep extends VPage {
    public function __construct($stepId) {
        parent::__construct();
        $this->add(new VFormStep($stepId));
    }

}