<?php

class VUser extends VList {
    public function __construct(int $userId = NULL) {
        $sql="SELECT * FROM users WHERE id=".$userId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("User: "));
        $this->add(new VLink($o->login, "/edit.php?type=us&id=$o->id"));
        $this->add(new VText(" (id=$o->id,login=$o->login,pwdHash=$o->pwdhash)"));
        $this->add(new VLink("delete", "/delete.php?type=us&id=$o->id"));
        $sqls->closeCursor();
    }

}