<?php

/**
 * @brief Model for plan object.
 */
class MPlan extends MObjectModel {
    /**
     * @const urlPrefix
     * Used for generating url for this model.
     */
    const urlPrefix = 'plan';
    /**
     * @var $seqId
     * Id of sequence planned in this model, loaded from database.
     */
    public $seqId;
    /**
     * @var $period
     * Period of time after which this plan is repeated, loaded from database.
     * The period is only a number describing the period, not actual time.
     */
    public $period;
    /**
     * @var $offset
     * Offset (in seconds) after the period, at which this plan is repeated, loaded from database.
     * Example: If every day at 13:23, $period is (day) and $offset is 13*3600+23*60.
     */
    public $offset;
    /**
     * @var $lastTs
     * Timestamp of moment this plan was started last time, loaded from database.
     */
    public $lastTs;
    /**
     * @var $tmpId
     * Id that is used during storing phase, if storing is successful, $id is set to $tmpId.
     */
    private $tmpId;

    /**
     * Constructs model using data from database.
     * @param $id Id of plan in database.
     */
    public function __construct($id = 0) {
        parent::__construct();
        if($id) {
            $sqls=DB::query("SELECT * FROM plans WHERE id=$id");
            $o=$sqls->fetchObject();
            if ($o) {
                $this->id = $o->id;
                $this->seqId = $o->seq_id;
                $this->period = $o->period;
                $this->offset = $o->offset;
                $this->lastTs = $o->last_ts;
            }
        }
    }

    /**
     * @brief Tries to store data to database.
     * @param null $arg Universal argument, not used here.
     * @return bool Storing was successful.
     */
    public function store(int $arg = 0) : bool {
        if (!parent::store()) return false; // TODO: Change the autogenerated stub
        $sql = $this->id ? "UPDATE" : "INSERT INTO";
        $sql.=" plans SET seq_id=:seq_id, period=:period, offset=:offset, last_ts=:last_ts";
        if ($this->id) $sql.=" WHERE id=$this->id";
        $sqls=DB::prepare($sql);
        $res = true;
        try {
            $res = $sqls->execute(["seq_id" => $this->seqId, "period" => $this->period,
                "offset" => $this->offset, "last_ts" => $this->lastTs]);
        } catch (PDOException) {
            $res = false;
        }
        if (!$res) {
            error_log(get_called_class().": SQL Error.");
            return false;
        }
        if (!$this->id) $this->tmpId = DB::lastInsertId();
        else $this->tmpId = $this->id;
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
        $sql = "DELETE FROM plans WHERE id=$this->id";
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
        if ($this->persist()) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Plan was saved."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Plan could not have been saved!"));
    }

    /**
     * Starts deleting process in database.
     * If not successful, reverts changes made. Adds notification to user about result.
     * @return bool
     */
    public function unpersist() : bool {
        $ret = parent::unpersist();
        if ($ret) VPageHollow::addNotification(new VNotification(VNotification::NT_Success, "Plan was deleted."));
        else VPageHollow::addNotification(new VNotification(VNotification::NT_Error, "Plan could not have been deleted!"));
        return $ret;
    }
}