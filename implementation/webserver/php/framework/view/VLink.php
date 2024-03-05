<?php

class VLink extends VView {
    protected $title;
    protected $url;

    public function __construct($title, $url) {
        $this->title = $title;
        $this->url = $url;
    }


    public function renderBody() {
        echo "<a href='$this->url'>$this->title</a>";
    }


}