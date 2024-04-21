<?php

class VFfDdChannelDevices extends VFormFieldDropdown {
    const Sql = "SELECT * FROM devices WHERE domain_id IN ";
    const PermName = "can_edit_devices";
}