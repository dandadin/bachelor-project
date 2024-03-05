<?php
require_once "../app/library.php";
new DB();

if(isset($_GET["id"])) {
    $id = $_GET["id"];
    echo "<h3>ID je ".$id."</h3>";
    $page = new VPageDeleteDevice($id);
    $page->render();
} else {
    echo "<h3>ID NENI</h3>";
}
