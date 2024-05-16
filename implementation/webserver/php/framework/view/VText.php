<?php

class VText extends VView {
    private $text;

    public function __construct($text) {
        $this->text = $text;
    }


    public function renderBody(): void {
        echo "$this->text";
    }

}