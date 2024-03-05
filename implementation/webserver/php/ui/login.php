<?php
require_once "../app/library.php";
new DB();

if (isset($_SESSION["loginId"])) {
    header("Location: /");
    exit();
}

$page = new VPageLogin();
$page->render();


