<?php

class VPageDeleteDevice extends VPage {
    public function __construct($deviceId) {
        parent::__construct();
        $d = new MDevice($deviceId);
        $d->delete();

        $page = new VDeviceList();
        $page->render();
    }

}