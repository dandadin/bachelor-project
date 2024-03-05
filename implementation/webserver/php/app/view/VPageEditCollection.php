<?php

class VPageEditCollection extends VPage {
    public function __construct($collId) {
        parent::__construct();
        $this->add(new VFormCollection($collId));
    }

}