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

function genFieldId() {
    if (!isset($_SESSION["genId"])) $_SESSION["genId"] = 0;
    return "f".++$_SESSION["genId"];
}

spl_autoload_register("autoload");

session_start();

if(!isset($_SESSION["loginId"]) || !$_SESSION["loginId"]) {
    if ($_SERVER["REQUEST_URI"] != "/login") {
        header("Location: /login");
        exit();
    }
}

new DB();

$m=PageContext::loadAllModels();
if ($m) if ($m->getUrl() !=$_SERVER["REQUEST_URI"]) {
    header("Location: ".$m->getUrl());
    exit();
}

VPageHollow::loadNotifications();
