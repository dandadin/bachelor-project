<?php
/**
 * @brief Universal model class template, that is used for storing objects between loads.
 */
class MModel {
    public function store($arg = NULL) {return true;}
    /**
     * @brief Used when storing in database was successful. Usually commits changes to model and database.
     * @return void
     */
    public function storeCommit() {}

    public function delete($arg = NULL) {return true;}
    /**
     * @brief Used to store data from model to database. If storing fails, reverts back.
     * @return bool Storing was successful
     */
    protected function persist() {
        DB::beginTransaction();
        if($this->store()) {
            DB::commit();
            $this->storeCommit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}