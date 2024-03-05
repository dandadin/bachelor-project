<?php

class CPassword extends Controller {

    public function update() {
        if(isset($_POST[$this->formField]))
            if ($_POST[$this->formField] !== "")
                $this->model = hash("sha256", $_POST[$this->formField]);
    }


}