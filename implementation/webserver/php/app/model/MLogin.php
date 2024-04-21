<?php

/**
 * @brief Model for login object. This object is used on login page.
 */
class MLogin extends MModel {
    /**
     * @var string $login Username posted by user.
     */
    public $login = "";
    /**
     * @var string $pwdHash Hash of password posted by user.
     */
    public $pwdHash = "";

    /**
     * @brief Tries to find inputted data in database.
     * If successful, sets SESSION variable "loginId" to id of logged-in user.
     * If not, unsets this SESSION variable.
     * @param null $arg Universal argument, not used here.
     * @return bool Check was successful.
     */
    public function store(int $arg = 0) {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = "SELECT * from users WHERE login=:login AND pwdhash=:pwdhash";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["login" => $this->login,
                "pwdhash" => $this->pwdHash]);
        } catch (PDOException) {
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        $o=$sqls->fetchObject();
        if ($o) {
            header("Location: /");
            $_SESSION["loginId"] = $o->id;
            self::reloadPerms();
            exit();
        }
        else {
            unset($_SESSION["loginId"]);
            self::reloadPerms();
            return false;
        }
    }

    /**
     * @brief Used for logging off. Removes SESSION variable loginId.
     * @return bool Removal was successful.
     */
    public function delete($arg = NULL) {
        if(isset($_SESSION["loginId"])) {
            unset($_SESSION["loginId"]);
            self::reloadPerms();
        }
        return TRUE;
    }

    /**
     * Starts checking process.
     * Called when button in edit form using this model is pressed. Adds notification to user about result.
     * @return void
     */
    public function clickedSubmit() {
        if ($this->persist()) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Successfully logged in!"));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Username or password was wrong!"));
    }

    /**
     * Loads active roles of logged-in user and saves their permissions to $_SESSION["perms"].
     * @return void
     */
    public static function reloadPerms() {
        if (!isset($_SESSION["loginId"])) {
            error_log(get_called_class().": No logged in.");
            $_SESSION["perms"] = new PermissionManager(-1);
            return;
        }
        error_log(get_called_class().": Logged in present.");
        $_SESSION["perms"] = new PermissionManager($_SESSION["loginId"]);
    }
}