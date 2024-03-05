<?php

class VGateway extends VList {
    public function __construct(int $gatewayId = NULL) {
        $sql="SELECT * FROM gateways WHERE id=".$gatewayId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Gateway: "));
        $this->add(new VLink($o->name, "/edit.php?type=ga&id=$o->id"));
        $this->add(new VText(" (id=$o->id,name=$o->name,address=$o->address)"));
        $this->add(new VLink("delete", "/delete.php?type=ga&id=$o->id"));
        $sqls->closeCursor();
    }

}