<?php

namespace JPustkuchen\TableClassBundle;

use JPustkuchen\TableClassBundle\Elements\HtmlAttributes;
use JPustkuchen\TableClassBundle\Elements\Table;
use JPustkuchen\TableClassBundle\Elements\TableRow;
use Twig\Environment;

class TableFactory {

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function createTable(?TableRow $header = null, array $rows = [], ?HtmlAttributes $attributes = null): Table {
        return new Table($this->twig, $header, $rows, $attributes);
    }
}
