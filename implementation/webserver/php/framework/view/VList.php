<?php

class VList extends VView {
    protected $items = array();

    public function add(VView $v) : void {
        $this->items[] = $v;
    }

    public function remove(VView $v) : void {
        $index = array_search($v, $this->items);
        if ($index !== false) unset($this->items[$index]);
    }

    protected function renderBody(): void {
        foreach ($this->items as $i) {
            $this->renderItem($i);
        }
    }

    protected function renderItem(VView $v) : void {
        $v->render();
    }

    public function registerController(FormContext $c) : void {
        foreach ($this->items as $i) {
            $i->registerController($c);
        }
    }

    public function disable(bool $disable = true) : VView {
        foreach($this->items as $item) {
            $item->disable($disable);
        }
        return $this;
    }
}