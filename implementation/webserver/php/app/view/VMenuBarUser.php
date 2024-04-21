<?php

class VMenuBarUser extends VMenuBar {
    protected function getMenu(): array {
        return ["Home" => "/", "Devices" => "/devices", "Sequences" => "/sequences",
            "Day Plan" => "/plans", "My Profile" => "/user/".$_SESSION["loginId"]."/edit", "Logout" => "/logout"];
    }
}