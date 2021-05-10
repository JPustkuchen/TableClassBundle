<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\HtmlAttributes;
use JPustkuchen\TableClassBundle\Elements\Table;
use JPustkuchen\TableClassBundle\Elements\TableRow;

class TableFactory {

    public function __construct()
    {

    }

    public function createTable(?TableRow $header, array $rows = [], ?HtmlAttributes $attributes): Table {
        return new Table($header, $rows, $attributes);
    }
}
