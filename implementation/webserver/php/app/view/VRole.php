<?php

class VRole extends VList {
    public function __construct(int $roleId = NULL) {
        $sql="SELECT * FROM roles WHERE id=".$roleId;
        $sqls=DB::prepare($sql);
        if (!$sqls->execute([])) die(get_called_class().": SQL Error.");

        $o=$sqls->fetchObject();
        $this->add(new VText("Role: "));
        $this->add(new VLink($o->name, "/edit.php?type=ro&id=$o->id"));
        $this->add(new VText(" (id=$o->id,name=$o->name,canEditGroups=$o->can_edit_groups,canEditUsers=$o->can_edit_users)"));
        $this->add(new VLink("delete", "/delete.php?type=ro&id=$o->id"));
        $sqls->closeCursor();
    }

}