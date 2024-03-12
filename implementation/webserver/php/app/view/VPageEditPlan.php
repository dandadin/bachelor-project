<?php

class VPageEditPlan extends VPage {
    public function __construct($planId) {
        parent::__construct();
        $this->add(new VFormPlan($planId));
    }

}