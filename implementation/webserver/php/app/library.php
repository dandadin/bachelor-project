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


/**
 * Inverse function for strtotime().
 * @param int $time Time in [s] from Unix epoch.
 * @return string Time in format for TIMESTAMP data type for MySQL.
 */
function timetostr(int $time) : string {
    return gmdate("Y-m-d H:i:s", $time);
}
