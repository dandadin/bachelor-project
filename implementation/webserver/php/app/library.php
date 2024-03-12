<?php

function autoload($name) {
    $dir = new RecursiveDirectoryIterator($_SERVER["DOCUMENT_ROOT"]);
    $locations = ["app", "app/model", "app/view",
        "framework", "framework/model", "framework/view",
        "framework/controller", "."];
    foreach ($locations as $l) {
        $file = $_SERVER["DOCUMENT_ROOT"]."/".$l."/".$name.".php";
        if(file_exists($file)) {
            require_once $file;
            return;
        }
    }
}
spl_autoload_register("autoload");

session_start();

function genFieldId() {
    if (!isset($_SESSION["genId"])) $_SESSION["genId"] = 0;
    return "f".++$_SESSION["genId"];
}

if(!isset($_SESSION["loginId"]) || !$_SESSION["loginId"]) {
    if ($_SERVER["REQUEST_URI"] != "/login.php") {
        header("Location: /login.php");
        exit();
    }
}

VPageHollow::loadNotifications();
