<?php

class MModel {
    const viewClass = NULL;

    public function storeCommit() {}

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