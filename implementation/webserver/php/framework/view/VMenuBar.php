<?php

class VMenuBar extends VList {

    public function __construct() {
        foreach ($this->getMenu() as $k => $v) {
            $this->add(new VMenuItem($k, $v));
        }
    }

    public function renderHeader(): void {
        echo <<<END
    <nav>
        <ul>\n
END;

    }

    public function renderFooter(): void {
        echo <<<END
        </ul>
    </nav>\n
END;
    }

    public function renderItem(VView $v): void {
        echo "<li>";
        parent::renderItem($v);
        echo "</li>\n";
    }

    protected function getMenu() : array {
        return array();
    }
}