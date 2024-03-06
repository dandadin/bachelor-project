<?php

/**
 * View for relative table listing collections.
 */
class VRTCollection extends VRelTable {
    /**
     * List of names for columns.
     */
    const Heading = ["Collection"];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRTRCollection::class;
}