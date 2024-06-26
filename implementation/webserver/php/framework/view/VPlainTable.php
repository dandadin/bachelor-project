<?php

/**
 * View for default table. This table's rows show single entity details.
 */
class VPlainTable extends VTable {

    public function __construct($heading, $sql, $rowClass, $deleteCol = "delete", $label = NULL) {
        parent::__construct($heading, $deleteCol, $label);
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        while($o=$sqls->fetchObject()) $this->add(new $rowClass($o));
        $sqls->closeCursor();
    }
}