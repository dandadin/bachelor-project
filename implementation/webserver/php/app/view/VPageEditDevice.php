<?php

class VPageEditDevice extends VPage {
    public function __construct($deviceId) {
        parent::__construct();
        $this->add(new VFormDevice($deviceId));
    }

    public static function checkPermissions(?int $id = null): string {
        if ($id === null || $id == -1) return "/devices";
        if ($id === 0) return "";
        if ($_SESSION["perms"]->canEditAll()) return "";
        $domains =  PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_edit_devices"));
        $sql = "SELECT 1 FROM dual WHERE EXISTS ".
            "( SELECT 1 FROM devices WHERE devices.id=".$id." AND ".
            "domain_id IN ". $domains .")";
        $sqls = DB::query($sql);
        if ($sqls->fetchObject()) return "/";
        return "";
    }
}