<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\Table;

class TableFactory
{

    public static function createTable(): Table
    {
        return new Table();
    }
}
