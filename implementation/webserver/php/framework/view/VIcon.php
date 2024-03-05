<?php

class VIcon extends VView {
    private $url;
    private $alt;

    public function __construct($url, $alt) {
        $this->url = $url;
        $this->alt = $alt;
    }

    protected function renderBody() {
        echo "<img src='$this->url' alt='$this->alt' class='icon-small'/>";
    }


}