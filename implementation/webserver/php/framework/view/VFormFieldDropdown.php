<?php

class VFormFieldDropdown extends VFormField {
    const Sql = "SELECT * FROM table";
    const LabelColumn = "name";
    const ValueColumn = "id";
    protected $filter;

    public function __construct(&$model = NULL, $label = NULL, $filter = "1=1") {
        $this->model = &$model;
        $this->fieldId = genFieldId();
        $this->label = $label;
        $this->filter = $filter;
    }

    public function renderHeader() {
        parent::renderHeader(); // TODO: Change the autogenerated stub
        echo "<select name='$this->fieldId' />";
    }

    protected function renderBody() {
        parent::renderBody(); // TODO: Change the autogenerated stub
        $sql=static::Sql." WHERE ".$this->filter;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $label = static::LabelColumn;
        $value = static::ValueColumn;
        while ($o=$sqls->fetchObject()) {
            echo "<option value='".$o->$value."' ".
                (($this->model == $o->$value) ? "selected=\"selected\"" : "").
                ">".$o->$label."</option>";
        }
        $sqls->closeCursor();
    }


    public function renderFooter() {
        echo "</select>";
        parent::renderFooter(); // TODO: Change the autogenerated stub
    }


    public function registerController(ControllerCollection $cc) {
        parent::registerController($cc); // TODO: Change the autogenerated stub
        $cc->add(new CDropdown($this->model, $this->fieldId));
    }


}