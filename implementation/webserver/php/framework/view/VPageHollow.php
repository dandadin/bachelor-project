<?php

class VPageHollow extends VList {

    protected const Title = "IoTHome";
    protected const Header = "";
    protected $title;
    protected $header;
    static protected $NotifList;

    public function __construct() {
        $this->title = static::Title;
        $this->header = static::Header;
        if(!static::$NotifList) static::$NotifList = new VList();
        $this->add(static::$NotifList);
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

    public function renderFooter() {
        echo "    </body></html>\n";
    }

    public const NT_Error = 0;
    public const NT_Success = 1;
    public const NT_Info = 2;

    public static function addNotification(VNotification $notification) {
        static::$NotifList->add($notification);
    }
}