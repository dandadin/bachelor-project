<?php

/**
 * View for relative table listing users and their roles.
 */
class VRTUserRoleInDom extends VRelTable {
    /**
     * List of names for columns.
     */
    const Heading = ["Username", "Role"];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRTRUserRoleInDom::class;
}