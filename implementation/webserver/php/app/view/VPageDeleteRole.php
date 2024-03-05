<?php

class VPageDeleteRole extends VPage {
    public function __construct($roleId) {
        parent::__construct();
        $d = new MRole($roleId);
        $d->delete();

        $page = new VRoleList();
        $page->render();
    }

}