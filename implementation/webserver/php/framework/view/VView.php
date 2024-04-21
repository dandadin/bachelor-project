<?php

abstract class VView {

    public function render() {
        $this->renderHeader();
        $this->renderBody();
        $this->renderFooter();
    }
    
    protected function renderHeader() {}
    protected function renderBody() {}
    protected function renderFooter() {}

    protected function registerController(FormContext $c) {}

    public function disable(bool $disable = true) {return $this;}
}