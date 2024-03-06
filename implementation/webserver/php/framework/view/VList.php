<?php

abstract class VList extends VView {
    protected $items = array();

    public function add(VView $v) {
        $this->items[] = $v;
    }

    public function remove(VView $v) {
        $index = array_search($v, $this->items);
        if ($index !== false) unset($this->items[$index]);
    }

    protected function renderBody() {
        foreach ($this->items as $i) {
            $this->renderItem($i);
        }
    }

    protected function renderItem(VView $v) {
        $v->render();
    }

    protected function registerController(ControllerCollection $cc) {
        foreach ($this->items as $i) {
            $i->registerController($cc);
        }
    }
}