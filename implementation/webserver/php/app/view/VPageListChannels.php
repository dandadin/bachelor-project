<?php

class VPageListChannels extends VPage {
    public function __construct() {
        parent::__construct();
        $this->add(new VText("<h1>Channels</h1>"));
        $this->add(new VPlainTable(["ID", "Name", "Device", "Communication Type", "Value Type", "Update Frequency [s]"], "SELECT channels.*, d.name AS dname FROM channels LEFT JOIN devices d on d.id = channels.device_id", VPTRChannel::class));
        $this->add(new VLink(new VText("add new"), "/edit.php?type=ch&id=0"));
    }

}