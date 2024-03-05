<?php

class VPageEditChannel extends VPage {
    public function __construct($channelId) {
        parent::__construct();
        $this->add(new VFormChannel($channelId));
    }

}