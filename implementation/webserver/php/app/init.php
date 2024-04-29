<?php
global $res;
spl_autoload_register("autoload");
require "/var/www/vendor/autoload.php";

session_start();

new DB();
new MQTTWS();

if (isset($res[1])) if($res[1]=="execute") {
    include "../executor.php";
    exit();
}

if (isset($res[1]) && isset($res[2])) if($res[1]=="gw")  {
    echo Communicator::loadGateway($res[2]) ? "OK" : "ERROR";
    exit();
}

if(!isset($_SESSION["loginId"]) || !$_SESSION["loginId"]) {
    if ($_SERVER["REQUEST_URI"] != "/login") {
        header("Location: /login");
        exit();
    }
}

$m=PageContext::loadAllModels();

if ($m) if ($m->getUrl()!=$_SERVER["REQUEST_URI"]) {
    header("Location: ".$m->getUrl());
    exit();
}

VPageHollow::loadNotifications();
