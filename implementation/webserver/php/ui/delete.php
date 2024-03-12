<?php
require_once "../app/library.php";
new DB();

if (isset($_GET["type"])) {
    $type = [
        "us" => "User",
        "do" => "Domain",
        "co" => "Collection",
        "de" => "Device",
        "ch" => "Channel",
        "ga" => "Gateway",
        "ro" => "Role"];

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $modelName = "M".$type[$_GET["type"]];
        $model = new $modelName($id);
        $model->unpersist();

        header("Location: /list.php?type=".$_GET["type"]);
        exit();
    } else {
        echo "<h3>ID NENI</h3>";
    }
} else {
    echo "<h3>TYPE NENI</h3>";
}


