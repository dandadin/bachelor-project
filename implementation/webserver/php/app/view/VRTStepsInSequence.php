<?php

/**
 * View for relative table listing steps.
 */
class VRTStepsInSequence extends VRelTable {
    /**
     * List of names for columns.
     */
    const Heading = ["ID", "Channel" , "Value", "Delay Before [s]"];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRTRStepsInSequence::class;
}