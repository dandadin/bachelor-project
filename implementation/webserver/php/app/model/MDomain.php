<?php

class MDomain extends MObjectModel {
    /**
     * @const urlPrefix
     * Used for generating url for this model.
     */
    const urlPrefix = 'domain';
    /**
     * @var $name
     * Name of domain loaded from database.
     */
    public $name;
    /**
     * @var MRTUserRoleInDom $userroles
     * List of models of every user and their roles belonging in this domain.
     */
    public $userroles;
    /**
     * @var $tmpId
     * Id that is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * Constructs model using data from database.
     * @param $id Id of domain in database.
     */
    public function __construct($id = 0) {
        parent::__construct();
        if($id) {
            $sqls=DB::query("SELECT * FROM domains WHERE id=$id");
            $o=$sqls->fetchObject();
            if ($o) {
                $this->id = $o->id;
                $this->name = $o->name;
            }
        }
        $this->userroles = new MRTUserRoleInDom($this->id);
    }

    /**
     * @brief Tries to store data to database.
     * @param null $arg Universal argument, not used here.
     * @return bool Storing was successful.
     */
    public function store(int $arg = 0) : bool {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" domains SET name=:name";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["name" => $this->name]);
        } catch (PDOException) {
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        if (!$this->id) $this->tmpId = DB::lastInsertId();
        else $this->tmpId = $this->id;
        if(!$this->userroles->store($this->tmpId)) return false;
        return true;
    }

    /**
     * @brief Used when storing in database was successful. Commits all changes to model and database.
     * @return void
     */
    public function storeCommit() : void {
        parent::storeCommit();
        if (!$this->id) $this->id = $this->tmpId;
    }

    /**
     * @brief Deletes corresponding record from database.
     * @return bool Deletion was successful.
     */
    public function delete($arg = NULL) : bool {
        if (!$this->id) return TRUE;
        $sql = "DELETE FROM collections WHERE domain_id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        $sql = "DELETE FROM devices WHERE domain_id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        $sql = "DELETE FROM domain_users WHERE domain_id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        $sql = "DELETE FROM domains WHERE id=$this->id";
        if (FALSE===DB::exec($sql)) return FALSE;
        if (FALSE===parent::delete()) return FALSE;
        $this->tmpId = NULL;
        return TRUE;
    }

    /**
     * Starts saving process to database.
     * Called when button in edit form using this model is pressed. Adds notification to user about result.
     * @return void
     */
    public function clickedSubmit() {
        if ($this->persist()) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Domain was saved."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Domain could not have been saved!"));
    }

    /**
     * Starts deleting process in database.
     * If not successful, reverts changes made. Adds notification to user about result.
     * @return bool
     */
    public function unpersist() : bool {
        $ret = parent::unpersist();
        if ($ret) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Domain was deleted."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Domain could not have been deleted!"));
        return $ret;
    }
}