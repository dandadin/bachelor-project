<?php


/**
 * View of dropdown item specified for listing users.
 */
class VFormFieldDropdownUser extends VFormFieldDropdown {
    const Sql = "SELECT * FROM users";
    public const LabelColumn = "login";
}