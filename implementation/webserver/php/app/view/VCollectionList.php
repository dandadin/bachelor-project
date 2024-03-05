<?php

class VCollectionList extends VList {
    public function __construct($filter = "1=1") { // model is an SQL condition
        $sql="SELECT id FROM collections WHERE ".$filter;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        while ($o=$sqls->fetchObject()) {
            $this->add(new VCollection($o->id));
            $this->add(new VText("<br>"));
        }
        $sqls->closeCursor();
    }

}