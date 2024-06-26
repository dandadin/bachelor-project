<?php
/**
 * Model of table-row of relative table of users. Stores single user.
 */
class MRTRUserInColl extends MModel {
    /**
     * @var $userId
     * Id of user this row used for creation.
     */
    public $userId;

    /**
     * Constructs model using data from database.
     * @param $userId Id of user this model is created for.
     */
    public function __construct($userId = 0) {
        $this->userId = $userId;
    }

    /**
     * If collId is specified, inserts this row into database.
     * @param null $collId Id of collection this user should be paired with.
     * @return bool Storing was successful.
     */
    public function store(int $collId = 0, int $index = 0) : bool {
        if (!$collId) return false;
        $sql = "INSERT INTO collection_users (coll_id, user_id) ".
               "SELECT :collId,id FROM users WHERE id=:userId ".
               "ON DUPLICATE KEY UPDATE user_id=user_id";

        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["collId" => $collId, "userId" => $this->userId]);
        } catch (PDOException) {$res = false;}
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        return true;
    }
}