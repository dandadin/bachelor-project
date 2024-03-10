<?php

class VPageHollow extends VList {

    protected const Title = "IoTHome";
    protected const Header = "";
    protected $title;
    protected $header;

    public function __construct() {
        $this->title = static::Title;
        $this->header = static::Header;
    }

    public function renderHeader() {
        echo <<<END
<html>
    <head>
        <title>$this->title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/style.css"/>
        $this->header
    </head>
    <body>\n
END;
    }

    public function renderFooter() {
        echo "    </body></html>\n";
    }
}