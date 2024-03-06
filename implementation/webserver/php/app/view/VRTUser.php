<?php

/**
 * View for relative table listing users.
 */
class VRTUser extends VRelTable {
    /**
     * List of names for columns.
     */
    const Heading = ["User"];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRTRUser::class;
}