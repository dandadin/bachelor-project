<?php

/**
 * View for default relative table. This table's rows can be added or deleted by user.
 */
class VRelTable extends VTable {
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
        parent::__construct(static::Heading, "remove", $label);
        $class = static::RowClass;
        foreach ($model->items as &$item) {
            $this->add(new $class($item, $model));
        }
        $this->addButton = new VFormFieldButton($model, "addItem", new VText("Add"),"","", "add-button");
    }

    /**
     * Renders the beginning of the table.
     * @return void
     */
    protected function renderHeader(): void {
        echo "<div class='table'>\n";
        parent::renderHeader(); // TODO: Change the autogenerated stub
    }

    /**
     * Renders the end of the table and the button for adding new rows.
     * @return void
     */
    protected function renderFooter(): void {
        parent::renderFooter(); // TODO: Change the autogenerated stub
        if($this->addButton) $this->addButton->render();
        echo "</div>\n";
    }

    /**
     * Registers controller of the adding button for parsing POST input.
     * @param $c FormContext Coontext containing collection of all registered controllers.
     * @return void
     */
    public function registerController(FormContext $c): void {
        parent::registerController($c);
        if($this->addButton) $this->addButton->registerController($c);
    }
}