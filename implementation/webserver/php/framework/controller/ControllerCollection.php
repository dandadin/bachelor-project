<?php

class ControllerCollection {
    private $controllers = array();

    public function update() {
        foreach ($this->controllers as $c) {
            $c->update();
        }
    }

    public function add(Controller $c) {
        $this->controllers[] = $c;
    }
}