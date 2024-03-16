<?php

/**
 * View of dropdown item specified for listing channels.
 */
class VFfDdChannel extends VFormFieldDropdown {
    const Sql = "SELECT CONCAT('(', d.name, '): ', channels.name) AS text FROM channels LEFT JOIN devices d on d.id = channels.device_id";
    const LabelColumn = "text";
    const ValueColumn = "channels.id";
}