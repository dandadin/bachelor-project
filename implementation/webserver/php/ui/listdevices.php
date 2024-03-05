<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/app/library.php";
new DB();

$page = new VPageListDevices();
$page->render();
