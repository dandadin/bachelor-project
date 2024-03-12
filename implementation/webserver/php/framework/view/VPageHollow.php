<?php

class VPageHollow extends VList {

    protected const Title = "IoTHome";
    protected const Header = "";
    protected $title;
    protected $header;

    public function __construct() {
        $this->title = static::Title;
        $this->header = static::Header;
        $this->add($_SESSION["notifications"]);
    }

    public function renderHeader() {
        echo <<<END
<html>
    <head>
        <title>$this->title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://kit.fontawesome.com/7313c0d6d7.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/style.css"/>
        $this->header
    </head>
    <body>\n
END;
    }

    public function render() {
        parent::render();
        $_SESSION["notifications"] = new VList();
    }

    public function renderFooter() {
        echo "    </body></html>\n";
    }

    public static function loadNotifications() {
        if(isset($_SESSION["notifications"])) if ($_SESSION["notifications"] instanceof VList) return;
        $_SESSION["notifications"] = new VList();
    }


    public static function addNotification(VNotification $notification) {
        $_SESSION["notifications"]->add($notification);
    }
}