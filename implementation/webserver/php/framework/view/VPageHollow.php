<?php

class VPageHollow extends VList {

    protected const Title = "IoTHome";
    protected $title;

    public function __construct() {
        $this->title = static::Title;
    }

    public function renderHeader() {
        echo <<<END
        <html>
            <head>
                <title>$this->title</title>
                <link rel="stylesheet" href="/css/style.css">
            </head>
            <body>
END;
    }

    public function renderFooter() {
        echo "</body></html>\n";
    }
}