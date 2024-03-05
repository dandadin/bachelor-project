<?php

class CText extends Controller {

    public function update() {
        if(isset($_POST[$this->formField])) $this->model = $_POST[$this->formField];
    }


}