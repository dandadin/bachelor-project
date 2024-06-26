<?php

/**
 * View for default table-row of relative table. This table's rows can be added or deleted by user.
 */
class VRelTabRow extends VList {

    /**
     * Constructs delete button view and adds it to the table.
     * @param $itemModel This model is passed to on-click method as an argument. Should be an instance of MRTR<type>.
     * @param $tableModel A method of this model will be called when the button is pressed. Should be an instance of MRelTable<type>
     */
    public function __construct(&$itemModel, &$tableModel) {
        $this->add(new VFormFieldButton($tableModel, "deleteItem", new VIcon("/icon/delete.png", "delete this record"), "", $itemModel, "delete-button"));
    }

    /**
     * Renders single cell of the table.
     * @param VView $v View of single cell of table.
     * @return void
     */
    protected function renderItem(VView $v): void {
        echo "<td>";
        parent::renderItem($v); // TODO: Change the autogenerated stub
        echo "</td>\n";
    }
}