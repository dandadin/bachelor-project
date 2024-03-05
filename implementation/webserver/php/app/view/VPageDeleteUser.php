<?php

class VPageDeleteUser extends VPage {
    public function __construct($userId) {
        parent::__construct();
        $d = new MUser($userId);
        $d->delete();

        $page = new VUserList();
        $page->render();
    }

}