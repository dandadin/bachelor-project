<?php

/**
 * Model for relative table of steps. Used to store list of steps that are part of specific sequence.
 */
class MRTStepsInSequence extends MRelTable {
    const RowModelClass = MRTRStepsInSequence::class;
    /**
     * Constructs model using data from database.
     * @param $seqId Id of sequence this model is created for.
     */
    public function __construct($seqId) {
        if($seqId) {
            $sqls=DB::query("SELECT * FROM steps WHERE seq_id=$seqId ORDER BY idx");

            while($o=$sqls->fetchObject()) {
                $this->items[] = new MRTRStepsInSequence($o->id);
            }
        }
    }
}