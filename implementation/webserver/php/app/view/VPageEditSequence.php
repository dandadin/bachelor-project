<?php

class VPageEditSequence extends VPage {
    public function __construct($sequenceId) {
        parent::__construct();
        $this->add(new VFormSequence($sequenceId));
    }

}