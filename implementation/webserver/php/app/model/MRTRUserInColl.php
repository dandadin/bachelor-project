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
    public function __construct($userId) {
        $this->userId = $userId;
    }

    /**
     * If collId is specified, inserts this row into database.
     * @param null $collId Id of collection this user should be paired with.
     * @return bool Storing was successful.
     */
    public function store($collId = NULL) {
        if (!$collId) return false;
        $sql = "INSERT INTO collection_users (coll_id, user_id) ".
               "SELECT id,:collId FROM users WHERE id=:userId";

        $sqls=DB::prepare($sql);
        if (!$sqls->execute(["collId" => $collId, "userId" => $this->userId]))
        {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        return true;
    }
}