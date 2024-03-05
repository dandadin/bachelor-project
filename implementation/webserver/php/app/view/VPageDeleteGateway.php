<?php

class VPageDeleteGateway extends VPage {
    public function __construct($gatewayId) {
        parent::__construct();
        $d = new MGateway($gatewayId);
        $d->delete();

        $page = new VGatewayList();
        $page->render();
    }

}