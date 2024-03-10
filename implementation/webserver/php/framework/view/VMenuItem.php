<?php

class VMenuItem extends VLink {
    public function __construct($title, $url) {
        parent::__construct(new VText($title), $url);
    }
}