<?php

/**
 * @brief Model for gateway object.
 */
class MGateway extends MModel {
    /**
     * @var $id
     * Id of gateway loaded form database.
     */
    public $id;
    /**
     * @var $name
     * Name of gateway loaded from database.
     */
    public $name;
    /**
     * @var $address Web address of gateway loaded from database.
     */
    public $address;
    /**
     * @var $tmpId
     * Id that is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * Constructs model using data from database.
     * @param $id Id of gateway in database.
     */
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

    /**
     * @brief Tries to store data to database.
     * @param null $arg Universal argument, not used here.
     * @return bool Storing was successful.
     */
    public function store($arg = NULL) {
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

    /**
     * @brief Used when storing in database was successful. Commits all changes to model and database.
     * @return void
     */
    public function storeCommit() {
        parent::storeCommit();
        if (!$this->id) $this->id = $this->tmpId;
    }

    /**
     * @brief Deletes corresponding record from database.
     * @return bool Deletion was successful.
     */
    public function delete($arg = NULL) {
        if (!$this->id) return TRUE;
        $sql = "DELETE FROM gateways WHERE id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        if (FALSE===parent::delete()) return FALSE;
        $this->tmpId = NULL;
        return TRUE;
    }

    /**
     * Starts saving process to database.
     * Called when button in edit form using this model is pressed.
     * @return void
     */
    public function clickedSubmit() {
        $this->persist();
    }


}