<?php

class VRelTable extends VList {
    const Heading = [];
    const RowClass = VRelTabRow::class;
    private $addButton;

    public function __construct(&$model, $label = NULL) {
        $this->add(new VRelTableHeading(static::Heading));
        $class = static::RowClass;
        foreach ($model->items as &$item) {
            $this->add(new $class($item));
        }
        $this->addButton = new VFormFieldButton($model, "addItem", new VText("Add"));
    }

    protected function renderItem(VView $v) {
        echo "<tr>";
        parent::renderItem($v); // TODO: Change the autogenerated stub
        echo "</tr>";
    }

    protected function renderHeader() {
        parent::renderHeader(); // TODO: Change the autogenerated stub
        echo "<table>";
    }

    protected function renderFooter() {
        echo "</table>";
        $this->addButton->render();
        parent::renderFooter(); // TODO: Change the autogenerated stub
    }

    protected function registerController($cc) {
        parent::registerController($cc);
        $this->addButton->registerController($cc);
    }
}