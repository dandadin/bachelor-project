<?php

class VPageEditInstance extends VPage {
    public function __construct($instanceId) {
        parent::__construct();
        $this->add(new VFormInstance($instanceId));
    }

    public static function checkPermissions(?int $id = null): string {
        if (!$_SESSION["perms"]->canEditAll()) return "/";
        return "";
    }
}