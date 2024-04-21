<?php

class VPageEditCollection extends VPage {
    public function __construct($collId) {
        parent::__construct();
        $this->add(new VFormCollection($collId));
    }

    public static function checkPermissions(?int $id = null): string {
        if ($id === null || $id == -1) return "/collections";
        if ($id === 0) return "";
        if ($_SESSION["perms"]->canEditAll()) return "";
        $domains =  PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_edit_colls"));
        $sql = "SELECT 1 FROM dual WHERE EXISTS ".
            "( SELECT 1 FROM collections ".
            "WHERE collections.id=".$id." AND domain_id IN ". $domains .")";
        $sqls = DB::query($sql);
        if ($sqls->fetchObject()) return "/";
        return "";
    }
}