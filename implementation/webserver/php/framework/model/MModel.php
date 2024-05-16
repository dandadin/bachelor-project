<?php
/**
 * @brief Universal model class template, that is used for storing objects between loads.
 */
class MModel {
    public function store(int $arg = 0) : bool {return true;}
    /**
     * @brief Used when storing in database was successful. Usually commits changes to model and database.
     * @return void
     */
    protected function storeCommit() : void {}

    protected function deleteCommit() : void {}

    public function delete($arg = NULL) : bool {return true;}
    /**
     * @brief Used to store data from model to database. If storing fails, reverts back.
     * @return bool Storing was successful
     */
    protected function persist() : bool {
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
    public function unpersist() : bool {
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