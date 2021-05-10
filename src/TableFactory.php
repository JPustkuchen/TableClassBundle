<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\Table;
use JPustkuchen\TableClassBundle\Elements\TableRow;

class TableFactory {

    public function __construct()
    {

    }

    public function createTable(): Table {
        return new Table();
    }
}
