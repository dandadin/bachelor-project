<?php

class CDropdown extends Controller {
    public function update() {
        if(isset($_POST[$this->formField])) $this->model = intval($_POST[$this->formField]);
    }

}