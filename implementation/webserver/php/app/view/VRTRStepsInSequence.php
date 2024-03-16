<?php

/**
 * View for table-row of relative table rendering steps.
 */
class VRTRStepsInSequence extends VRelTabRow {

    /**
     * Constructs views for every cell and adds it to the table.
     * @param $itemModel Should be an instance of MRTR<type> containing data of this row.
     * @param $tableModel Should be an instance of MRelTable<type> this row is created for.
     */
    public function __construct(&$itemModel, &$tableModel) {
        $this->add(new VText($itemModel->id));
        $this->add(new VFfDdChannel($itemModel->channelId));
        $this->add(new VFormFieldText($itemModel->value));
        $this->add(new VFormFieldNumber($itemModel->delayBefore));

        parent::__construct($itemModel, $tableModel);
    }
}