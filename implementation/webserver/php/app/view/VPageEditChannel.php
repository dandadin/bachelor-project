<?php

class VPageEditChannel extends VPage {
    public function __construct($channelId) {
        parent::__construct();
        $this->add(new VFormChannel($channelId));
    }
    public static function checkPermissions(?int $id = null): string {
        if ($id === null || $id == -1) return "/channels";
        if ($id === 0) return "";
        if ($_SESSION["perms"]->canEditAll()) return "";
        $domains =  PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_edit_devices"));
        $sql = "SELECT 1 FROM dual WHERE EXISTS ".
            "( SELECT 1 FROM channels LEFT JOIN devices ON channels.device_id = devices.id ".
            "LEFT JOIN domains on domains.id = devices.domain_id WHERE channels.id=".$id." AND ".
            "domains.id IN ". $domains .")";
        $sqls = DB::query($sql);
        if ($sqls->fetchObject()) return "";
        return "";
    }
}