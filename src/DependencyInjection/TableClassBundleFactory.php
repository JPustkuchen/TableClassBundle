<?php

namespace App\JPustkuchenTableClassBundle\Service;

use App\Helpers\TableClassBundle\TableRow;
use App\Helpers\TableClassBundle\Table;

class TableClassBundleFactory {
  /**
   * Factory for a TableClassBundle Table.
   *
   * @param TableRow $header
   * @param array $rows
   * @param array $classes
   * @param array $attributes
   * @return Table
   */
  public function create(TableRow $header = null, array $rows = [], array $classes = [], array $attributes = []): Table {
    return new Table($header, $rows, $classes, $attributes);
  }
}
