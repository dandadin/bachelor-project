<?php

class VLink extends VView {
    protected VView $title;
    protected $url;
    protected $class;

    public function __construct(VView $title, $url, $class = "") {
        $this->title = $title;
        $this->url = $url;
        $this->class = $class;
    }


    public function renderBody() {
        echo "<a href='$this->url'";
        if ($this->class) echo " class='$this->class'";
        echo ">";
        $this->title->render();
        echo "</a>";
    }


}