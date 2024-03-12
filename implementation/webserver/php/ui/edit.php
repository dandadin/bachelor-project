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
        "ro" => "Role",
        "se" => "Sequence",
        "st" => "Step",
        "in" => "Instance",
        "pl" => "Plan"];

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $name = "VPageEdit".$type[$_GET["type"]];
        $page = new $name($id);
        $page->render();
    } else {
        echo "<h3>ID NENI</h3>";
    }
} else {
    echo "<h3>TYPE NENI</h3>";
}


