<?php

/**
 * View for relative table listing users.
 */
class VRTUserInColl extends VRelTable {
    /**
     * List of names for columns.
     */
    const Heading = ["User"];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRTRUserInColl::class;
}