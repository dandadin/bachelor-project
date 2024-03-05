<?php

class VPageDeleteCollection extends VPage {
    public function __construct($collId) {
        parent::__construct();
        $d = new MCollection($collId);
        $d->delete();

        $page = new VCollectionList();
        $page->render();
    }

}