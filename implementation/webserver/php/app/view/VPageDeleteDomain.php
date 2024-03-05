<?php

class VPageDeleteDomain extends VPage {
    public function __construct($domainId) {
        parent::__construct();
        $d = new MDomain($domainId);
        $d->delete();

        $page = new VDomainList();
        $page->render();
    }

}