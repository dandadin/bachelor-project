<?php

class VPageListCollections extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VCollectionList());
        $this->add(new VLink("add new", "/edit.php?type=co&id=0"));
    }

}