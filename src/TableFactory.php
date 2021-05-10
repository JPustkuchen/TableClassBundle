<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\HtmlAttributes;
use JPustkuchen\TableClassBundle\Elements\Table;
use JPustkuchen\TableClassBundle\Elements\TableRow;

class TableFactory {

    public function __construct()
    {

    }

    public function createTable(?TableRow $header = null, array $rows = [], ?HtmlAttributes $attributes = null): Table {
        return new Table($header, $rows, $attributes);
    }
}
