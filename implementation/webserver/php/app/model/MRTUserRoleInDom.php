<?php

/**
 * Model for relative table of users and roles. Used to store list of users that are included in specific collection.
 */
class MRTUserRoleInDom extends MRelTable {
    const RowModelClass = MRTRUserRoleInDom::class;
    /**
     * Constructs model using data from database.
     * @param $domainId Id of domain this model is created for.
     */
    public function __construct($domainId) {
        if($domainId) {
            $sqls=DB::query("SELECT * FROM domain_users LEFT JOIN users u ON domain_users.user_id = u.id WHERE domain_id=$domainId" );

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRUserRoleInDom($o->user_id, $o->role_id);
            }
        }
    }

    /**
     * If domainId is supplied, removes all records between this domain and any user and their role,
     * and then re-adds them using data supplied in POST by user.
     * @param int $domainId Id of domain this model is created for.
     * @return bool Storing was successful.
     */
    public function store(int $domainId = 0) : bool {
        if (!$domainId) return false;
        $sql = "DELETE FROM domain_users WHERE domain_id=$domainId";
        if (FALSE===DB::exec($sql)) return FALSE;

        if(!parent::store($domainId)) return false;

        return true;
    }
}