<?php

class VChannel extends VList {
    public function __construct(int $channelId = NULL) {
        $sql="SELECT * FROM channels WHERE id=".$channelId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Channel: "));
        $this->add(new VLink($o->name, "/edit.php?type=ch&id=$o->id"));
        $this->add(new VText(" (id=$o->id,name=$o->name,device=$o->device_id,comm_t=$o->comm_type,val_t=$o->value_type,update_freq=$o->update_freq)"));
        $this->add(new VLink("delete", "/delete.php?type=ch&id=$o->id"));
        $sqls->closeCursor();
    }

}