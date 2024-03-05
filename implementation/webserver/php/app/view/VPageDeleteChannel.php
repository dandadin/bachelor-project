<?php

class VPageDeleteChannel extends VPage {
    public function __construct($channelId) {
        parent::__construct();
        $d = new MChannel($channelId);
        $d->delete();

        $page = new VChannelList();
        $page->render();
    }

}