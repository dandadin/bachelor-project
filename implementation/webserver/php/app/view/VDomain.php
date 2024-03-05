<?php

class VDomain extends VList {
    public function __construct(int $domainId = NULL) {
        $sql="SELECT * FROM domains WHERE id=".$domainId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Domain: "));
        $this->add(new VLink($o->name, "/edit.php?type=do&id=$o->id"));
        $this->add(new VText(" (id=$o->id,name=$o->name)"));
        $this->add(new VLink("delete", "/delete.php?type=do&id=$o->id"));
        $sqls->closeCursor();
    }

}