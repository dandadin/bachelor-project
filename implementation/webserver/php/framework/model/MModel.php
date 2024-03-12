<?php
/**
 * @brief Universal model class template, that is used for storing objects between loads.
 */
class MModel {
    public function store(int $arg = 0) {return true;}
    /**
     * @brief Used when storing in database was successful. Usually commits changes to model and database.
     * @return void
     */
    protected function storeCommit() {}

    protected function deleteCommit() {}

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
    /**
     * @brief Used to remove data from database. If removing fails, reverts back.
     * @return bool Removal was successful
     */
    public function unpersist() {
        DB::beginTransaction();
        if($this->delete()) {
            DB::commit();
            $this->deleteCommit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}