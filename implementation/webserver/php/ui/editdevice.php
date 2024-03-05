<?php
require_once "../app/library.php";
new DB();

$page = new VPageEditDevice(1);
$page->render();
