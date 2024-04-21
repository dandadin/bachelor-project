<?php

class VPageListInstances extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Instances</h1>"));
        $this->add(new VPlainTable(["ID", "Sequence Name", "Current Step ID", "Step Planned Time"],
            "SELECT instances.*, s.name AS sname FROM instances LEFT JOIN sequences s on instances.seq_id = s.id",
            VPTRInstance::class));
        $this->add(new VLink(new VText("Add New"), "/instance/new", "button-link"));
    }
    public static function checkPermissions(?int $id = null): string {
        if (!$_SESSION["perms"]->canEditAll()) return "/";
        return "";
    }
}