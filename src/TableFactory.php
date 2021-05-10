<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\Table;

class TableFactory
{

    public static function createTable(?TableRow $header = null, array $rows = [], array $classes = [], array $attributes = []): Table
    {
        return new Table($header, $rows, $classes, $attributes);
    }
}
