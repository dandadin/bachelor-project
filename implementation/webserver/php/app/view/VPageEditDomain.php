<?php

class VPageEditDomain extends VPage {
    public function __construct($domainId) {
        parent::__construct();
        $this->add(new VFormDomain($domainId));
    }

}