<?php

class VFfDdInstanceSteps extends VFormFieldDropdown {
    const Sql = "SELECT steps.*, c.name AS cname, d.name AS dname FROM steps ".
                "LEFT JOIN channels c on c.id = steps.channel_id LEFT JOIN devices d on d.id = c.device_id";

    protected function renderBody(): void {
        $sql= static::Sql;
        error_log("SQL: ".$sql);
        $sqls=DB::prepare($sql);
        error_log("jsem tady");
        try {
            $sqls->execute([]);
        } catch (PDOException $exception) {
            error_log(get_called_class().": SQL Error: ".$exception->getMessage());
        }
        $value = static::ValueColumn;
        while ($o=$sqls->fetchObject()) {
            echo "<option value='".$o->$value."' ".
                (($this->model == $o->$value) ? "selected=\"selected\"" : "").
                ">($o->dname)[$o->cname]: $o->value</option>";
        }
        $sqls->closeCursor();
    }
}