<?php

class VDevice extends VList {
    public function __construct(int $deviceId = NULL) {
        $sql="SELECT * FROM devices WHERE id=".$deviceId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Device: "));
        $this->add(new VLink($o->name, "/edit.php?type=de&id=$o->id"));
        $this->add(new VText(" (id=$o->id,name=$o->name,location=$o->location,gw=$o->gateway_id,created=$o->created,lc=$o->last_changed)"));
        $this->add(new VLink("delete", "/delete.php?type=de&id=$o->id"));
        $sqls->closeCursor();
    }

}