<?php

class VMenuBar extends VList {
    const Menu = [];

    public function __construct() {
        foreach (static::Menu as $k => $v) {
            $this->add(new VMenuItem($k, $v));
        }
    }

    public function renderHeader() {
        echo <<<END
    <nav>
        <ul>
END;

    }

    public function renderFooter() {
        echo <<<END
        </ul>
    </nav>
END;
    }

    public function renderItem(VView $v) {
        echo "<li>";
        parent::renderItem($v);
        echo "</li>";
    }
}