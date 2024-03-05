<?php

class VPageListChannels extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VChannelList());
        $this->add(new VLink("add new", "/edit.php?type=ch&id=0"));
    }

}