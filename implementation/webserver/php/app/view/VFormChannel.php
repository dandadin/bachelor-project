<?php

class VFormChannel extends VForm {
    const FormId = "editChannel";
    const ModelClass = MChannel::class;

    public function __construct($channelId) {
        parent::__construct($channelId);
        $sqls=DB::query("SELECT 1 FROM dual WHERE EXISTS(".
            "SELECT 1 FROM channels LEFT JOIN devices d on d.id = channels.device_id WHERE channels.id = ".$channelId.
            " AND domain_id IN ". PermissionManager::arrayToSQL($_SESSION["perms"]->getDomainsByPerm("can_edit_devices")) .")");
        $canEdit = (bool)$sqls->fetchObject();
        if (!$canEdit) $canEdit = $_SESSION["perms"]->canEditAll();
        $this->add((new VFormFieldText($this->model->name, "Name"))->disable(!$canEdit));
        $this->add((new VFfDdChannelDevices($this->model->deviceId, "Device"))->disable(!$canEdit));
        $this->add((new VFormFieldNumber($this->model->commType, "Communication Type"))->disable(!$canEdit));
        $this->add((new VFormFieldNumber($this->model->valueType, "Value Type"))->disable(!$canEdit));
        $this->add((new VFormFieldNumber($this->model->updateFreq, "Update Frequency"))->disable(!$canEdit));
        $this->add((new VFormFieldButtonSubmit($this->model, new VText("Apply"), ""))->disable(!$canEdit));
    }



}