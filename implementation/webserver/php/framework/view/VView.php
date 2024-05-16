<?php

abstract class VView {

    public function render() : void {
        $this->renderHeader();
        $this->renderBody();
        $this->renderFooter();
    }
    
    protected function renderHeader() : void {}
    protected function renderBody() : void {}
    protected function renderFooter() : void {}

    protected function registerController(FormContext $c) : void {}

    public function disable(bool $disable = true) : VView {return $this;}
}