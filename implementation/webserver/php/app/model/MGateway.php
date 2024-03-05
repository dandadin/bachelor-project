<?php

class MGateway extends MModel {
    public const viewClass = "VFormGateway";
    public $id;
    public $name;
    public $address;
    private $tmpId;

    public function __construct($id) {
        if($id) {
            $sqls=DB::query("SELECT * FROM gateways WHERE id=$id");
            $o=$sqls->fetchObject();
            if ($o) {
                $this->id = $o->id;
                $this->name = $o->name;
                $this->address = $o->address;
            }
        }
    }

    public function store() {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" gateways SET name=:name, address=:address";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        if (!$sqls->execute(["name" => $this->name, "address" => $this->address]))
        {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        if (!$this->id) $this->tmpId = DB::lastInsertId();
        return true;
    }

    public function storeCommit() {
        parent::storeCommit();
        if (!$this->id) $this->id = $this->tmpId;
    }

    public function delete() {
        if (!$this->id) return TRUE;
        $sql = "DELETE FROM gateways WHERE id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        if (FALSE===parent::delete()) return FALSE;
        $this->tmpId = NULL;
        return TRUE;
    }

    public function clickedSubmit() {
        $this->persist();
    }


}