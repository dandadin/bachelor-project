<?php

class VCollection extends VList {
    public function __construct(int $collId = NULL) {
        $sql="SELECT * FROM collections WHERE id=".$collId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Collection: "));
        $this->add(new VLink($o->name, "/edit.php?type=co&id=$o->id"));
        $this->add(new VText(" $o->name (id=$o->id,name=$o->name,domain=$o->domain_id)"));
        $this->add(new VLink("delete", "/delete.php?type=co&id=$o->id"));
        $sqls->closeCursor();
    }

}