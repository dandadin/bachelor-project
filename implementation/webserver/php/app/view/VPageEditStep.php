<?php

class VPageEditStep extends VPage {
    public function __construct($stepId) {
        parent::__construct();
        $this->add(new VFormStep($stepId));
    }

    public static function checkPermissions(?int $id = null): string {
        if (!$_SESSION["perms"]->canEditAll()) return "/";
        return "";
    }
}