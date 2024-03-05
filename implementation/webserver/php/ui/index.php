<?php
    require_once "../app/library.php";
    new DB();

    $page = new VPageHome();
    $page->render();
