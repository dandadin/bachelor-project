<?php

class VDeviceList extends VList {
    public function __construct($filter = "1=1") { // model is an SQL condition
        $sql="SELECT id FROM devices WHERE ".$filter;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        while ($o=$sqls->fetchObject()) {
            $this->add(new VDevice($o->id));
            $this->add(new VText("<br>"));
        }
        $sqls->closeCursor();
    }

}