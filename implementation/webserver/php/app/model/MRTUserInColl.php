<?php

/**
 * Model for relative table of users. Used to store list of users that are included in specific collection.
 */
class MRTUserInColl extends MRelTable {
    const RowModelClass = MRTRUserInColl::class;
    /**
     * Constructs model using data from database.
     * @param $collId Id of collection this model is created for.
     */
    public function __construct($collId) {
        if($collId) {
            $sqls=DB::query("SELECT * FROM collection_users WHERE coll_id=$collId");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRUserInColl($o->user_id);
            }
        }
    }

    /**
     * If collId is supplied, removes all records between this collection and any user,
     * and then re-adds them using data supplied in POST by user.
     * @param int $collId Id of collection this model is created for.
     * @return bool Storing was successful.
     */
    public function store(int $collId = 0) {
        if (!$collId) {
            return false;
        }
        $sql = "DELETE FROM collection_users WHERE coll_id=$collId";
        if (FALSE===DB::exec($sql)) {
            return FALSE;
        }

        if(!parent::store($collId)) return false;

        return true;
    }
}