<?php
    require_once "../app/library.php";
    $res = explode('/', parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH));
    require_once "../app/init.php";

    $objects = [
    "user" => "User",
    "domain" => "Domain",
    "collection" => "Collection",
    "device" => "Device",
    "channel" => "Channel",
    "gateway" => "Gateway",
    "role" => "Role",
    "sequence" => "Sequence",
    "step" => "Step",
    "instance" => "Instance",
    "plan" => "Plan"];

    foreach($objects as $urlName => $cname) {
        if ($res[1]==$urlName) {
            if (!isset($res[2])) continue;
            if ($res[2]=='new') {
                $className = "VPageEdit".$cname;
                $page = new $className(0);
                $page->render();
                exit();
            } else {
                $id=intval($res[2]);
                if (!$id) continue;
                if (!isset($res[3])) continue;
                if ($res[3]=='edit') {
                    $className = "VPageEdit".$cname;
                    $page = new $className($id);
                    $page->render();
                    exit();
                } elseif ($res[3]=='delete') {
                    $modelName = "M".$cname;
                    $model = new $modelName($id);
                    $model->unpersist();
                    header("Location: /{$urlName}s");
                    exit();
                }
            }
        } elseif ($res[1]==$urlName."s") {
            $className = "VPageList".$cname."s";
            $page = new $className();
            $page->render();
            exit();
        }
    }

    $otherPages = [
        "login" => "VPageLogin",
        "logout" => "VPageLogout",
        "" => "VPageHome"
    ];

    //error_log("res[1] je '$res[1]'");
    foreach ($otherPages as $urlName => $cname) {
        error_log("urlName==$urlName");
        if ($res[1]==$urlName) {
            $page = new $cname();
            $page->render();
            exit();
        }
    }

    header("Location: /");

   /*
    /devices
    /device/35/edit
    /device/35/delete
    /device/new

    /
    /login
    /logout
   */