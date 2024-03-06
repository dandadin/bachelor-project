<?php

/**
 * View for default relative table. This table's rows can be added or deleted by user.
 */
class VRelTable extends VList {
    /**
     * List of names for columns.
     */
    const Heading = [];
    /**
     * Name of method used for viewing single row.
     */
    const RowClass = VRelTabRow::class;
    /**
     * @var VFormFieldButton View of button used to adding new row to the table.
     */
    private $addButton;

    /**
     * Creates view for header of the table and adds rows for items passed in $model.
     * @param $model An instance of model MRelTable<type>. Member $items stores an array of MRTR<type> models.
     * @param $label Not used.
     */
    public function __construct(&$model, $label = NULL) {
        $this->add(new VRelTableHeading(static::Heading));
        $class = static::RowClass;
        foreach ($model->items as &$item) {
            $this->add(new $class($item, $model));
        }
        $this->addButton = new VFormFieldButton($model, "addItem", new VText("Add"));
    }

    /**
     * Renders single row of the table.
     * @param VView $v View of single row of table.
     * @return void
     */
    protected function renderItem(VView $v) {
        echo "<tr>";
        parent::renderItem($v); // TODO: Change the autogenerated stub
        echo "</tr>";
    }

    /**
     * Renders the beginning of the table.
     * @return void
     */
    protected function renderHeader() {
        parent::renderHeader(); // TODO: Change the autogenerated stub
        echo "<table>";
    }

    /**
     * Renders the end of the table and the button for adding new rows.
     * @return void
     */
    protected function renderFooter() {
        echo "</table>";
        $this->addButton->render();
        parent::renderFooter(); // TODO: Change the autogenerated stub
    }

    /**
     * Registers controller of the adding button for parsing POST input.
     * @param $cc ControllerCollection Collection of all registered controllers.
     * @return void
     */
    protected function registerController(ControllerCollection $cc) {
        parent::registerController($cc);
        $this->addButton->registerController($cc);
    }
}