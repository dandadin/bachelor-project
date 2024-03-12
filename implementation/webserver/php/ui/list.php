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

    $name = "VPageList".$type[$_GET["type"]]."s";
    $page = new $name();
    $page->render();
} else {
    echo "<h3>TYPE NENI</h3>";
}


