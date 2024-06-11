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
    return date("Y-m-d H:i:s", $time);
}

/**
 * Tries to extract id from requested url (required in a format of an array of parts of url, separated by '/').
 * @param array $urlArray Requested url. (Can by obtained by string->explode());
 * @return int Id from url (if possible).
 * @retval 0 Request was for a creation of a new object (that doesnt have an id yet).
 * @retval -1 Request did not specify an id.
 * @retval ELSE Id from url.
 */
function extractId(array $urlArray) : int {
    if (isset($urlArray[2]) && is_numeric($urlArray[2])) {
        return $urlArray[2];
    }
    if (isset($urlArray[2]) && $urlArray[2] == "new") {
        return 0;
    }
    return -1;
}