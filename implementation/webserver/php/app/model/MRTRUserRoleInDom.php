<?php
/**
 * Model of table-row of relative table of users and their roles. Stores single combination of user and role.
 */
class MRTRUserRoleInDom extends MModel {
    /**
     * @var string $login
     * Username of user this row used for creation.
     */
    public string $login;
    /**
     * @var int $userId
     * Id of user this row used for creation.
     */
    public int $userId;
    /**
     * @var int $roleId
     * Id of role this row used for creation.
     */
    public int $roleId;

    /**
     * Constructs model using data from database.
     * @param int $userId Id of user this model is created for.
     * @param int $roleId Id of role this model is created for.
     */
    public function __construct(int $userId = 0, int $roleId = 0) {
        $this->userId = $userId;
        $this->login = "";
        $this->roleId = $roleId;
    }

    /**
     * If domainId is specified, inserts this row into database.
     * @param int $domainId Id of domain this user and role should be paired with.
     * @return bool Storing was successful.
     */
    public function store(int $domainId = 0, int $index = 0) : bool {
        if (!$domainId) {
            error_log(get_called_class().": Empty domainId");
            return false;
        }

        $sql = "SELECT id FROM users WHERE id=:userId OR (:userId = 0 AND login=:login)";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["userId" => $this->userId, "login" => $this->login]);
        } catch (PDOException) {$res = false;}
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        $o=$sqls->fetchObject();
        if(!$o) {
            $this->userId = 0;
            $this->login = "";
            error_log(get_called_class().": Warning: User not found. (id:$this->userId, login:$this->login)");
            return false;
        }
        $this->userId = $o->id;
        error_log("Provedlo se nastaveni:userId = o->id; $this->userId = $o->id;");


        $sql = "INSERT INTO domain_users (domain_id, user_id, role_id) ".
               "SELECT :domainId,:userId,id FROM roles WHERE id=:roleId";

        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["domainId" => $domainId, "userId" => $this->userId, "roleId" => $this->roleId]);
        } catch (PDOException) {$res = false;}
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        return true;
    }
}