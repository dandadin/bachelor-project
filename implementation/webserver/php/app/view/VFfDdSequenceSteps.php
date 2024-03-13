<?php

class VFfDdSequenceSteps extends VFormFieldDropdown {
    const Sql = "SELECT steps.*, c.name AS cname, d.name AS dname FROM steps ".
                "LEFT JOIN channels c on c.id = steps.channel_id LEFT JOIN devices d on d.id = c.device_id";

    protected function renderBody() {
        $sql=static::Sql." WHERE ".$this->filter;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $value = static::ValueColumn;
        while ($o=$sqls->fetchObject()) {
            echo "<option value='".$o->$value."' ".
                (($this->model == $o->$value) ? "selected=\"selected\"" : "").
                ">($o->dname)[$o->cname]: $o->value</option>";
        }
        $sqls->closeCursor();
    }
}