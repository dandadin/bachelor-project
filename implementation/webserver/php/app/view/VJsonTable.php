<?php

/**
 * View for default table. This table's rows show single entity details.
 */
class VJsonTable extends VTable {

    public function __construct($heading, $jsonArray, $rowClass, $label = NULL) {
        if ($jsonArray) {
            parent::__construct($heading, "", $label);
            foreach ($jsonArray as $jsonItem) $this->add(new $rowClass($jsonItem));
        }
    }
}