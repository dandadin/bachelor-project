<?php

/**
 * @brief Model for user object.
 */
class MUser extends MModel {
    /**
     * @var $id
     * Id of user loaded from database.
     */
    public $id;
    /**
     * @var $login
     * Username of user loaded from database.
     */
    public $login;
    /**
     * @var $pwdHash
     * Hash of chosen password loaded from database.
     * Password is hashed on server, in controller of password form input.
     */
    public $pwdHash;
    /**
     * @var $tmpId
     * Id is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * Constructs model using data from database.
     * @param $id Id of user in database.
     */
    public function __construct($id) {
        if($id) {
            $sqls=DB::query("SELECT * FROM users WHERE id=$id");
            $o=$sqls->fetchObject();
            if ($o) {
                $this->id = $o->id;
                $this->login = $o->login;
                $this->pwdHash = $o->pwdhash;
            }
        }
    }

    /**
     * @brief Tries to store data to database.
     * @param null $arg Universal argument, not used here.
     * @return bool Storing was successful.
     */
    public function store(int $arg = 0) {
        if (!parent::store($arg)) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" users SET login=:login, pwdHash=:pwdHash";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        if (!$sqls->execute(["login" => $this->login, "pwdHash" => $this->pwdHash]))
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
        $sql = "DELETE FROM users WHERE id=$this->id";
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