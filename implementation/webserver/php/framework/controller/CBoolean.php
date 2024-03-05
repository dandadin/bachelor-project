<?php

class CBoolean extends Controller {
    public function update() {
        $this->model = (isset($_POST[$this->formField])) ? 1 : 0 ;
    }

}