<?php

namespace JPustkuchen\TableClassBundle\Elements;

use Exception;

/**
 * Represents an HTML Table Row.
 */
class TableRow extends HtmlEntity {
  /**
   * Array of table cells in the table order (numeric index).
   */
  private array $cells = [];

  /**
   * A further array of table cells by key, not by table order.
   * Pointing to the same cell objects as $cells.
   */
  private array $cellsByKey = [];

  /**
   * Creates a TableRow from an array
   *
   * @param array $cellsArray
   */
  public static function createFromArray(array $cellsArray) {
    $cells = [];
    if (!empty($cellsArray)) {
      foreach ($cellsArray as $key => $cell) {
        if (!is_array($cell)) {
          // No array, use value as value:
          $cells[] = new TableCell($key, $cell);
        } else {
          // Array value, use by keys:
          $value = $cell['#value'];
          $classes = $cell['#classes'];
          $attributes = $cell['#attributes'];
          $cells[] = new TableCell($key, $value, $classes, $attributes);
        }
      }
    }
    return new self($cells);
  }

  /**
   * Constructor.
   *
   * @param array $cells
   * @param array $classes
   * @param array $attributes
   */
  public function __construct(array $cells = [], ?HtmlAttributes $attributes = null) {
    $this->setCells($cells);
    parent::__construct($attributes);
  }

  /**
   * Get the value of cells
   */
  public function getCells(): array {
    return $this->cells;
  }

  /**
   * Set the value of cells
   *
   * @return  self
   */
  public function setCells(array $cells): TableRow {
    $this->cells = [];
    if (!empty($cells)) {
      foreach ($cells as $cell) {
        $this->addCell($cell);
      }
    }
    return $this;
  }

  /**
   * Adds a cell by its unique key.
   *
   * @param TableCell $cell
   * @return TableRow
   */
  public function addCell(TableCell $cell): TableRow {
    $cellKey = $cell->getKey();
    if ($this->hasCell($cellKey)) {
      throw new Exception("Cell with Key {$cellKey} already exists in this row. Can not be added twice!");
    }
    $this->setCell($cellKey, $cell);
    return $this;
  }

  /**
   * Sets a cell by its key.
   *
   * @param string] $key
   * @param TableCell $cell
   * @return TableRow
   */
  protected function setCell(string $key, TableCell $cell): TableRow {
    $this->cells[] = $cell;
    $this->cellsByKey[$key] = $cell;
    return $this;
  }

  public function removeCell(string $key): TableRow {
    foreach ($this->cells as $index => $cell) {
      if ($cell->getKey() === $key) {
        unset($this->cellsByKey[$key]);
        unset($this->cells[$index]);
        break;
      }
    }
    return $this;
  }

  /**
   * Returns a cell by key.
   *
   * @param string] $key
   */
  protected function getCellByKey(string $key): TableCell {
    return $this->cellsByKey[$key];
  }

  /**
   * Returns a TableCell by index.
   *
   * @param int $index
   */
  public function getCellByIndex(int $index): TableCell {
    return $this->cells[$index];
  }

  /**
   * Returns true if a cell with the given key exists.
   *
   * @param string $key
   * @return bool
   */
  protected function hasCell(string $key): bool {
    return isset($this->cells[$key]);
  }

  /**
   * Returns an array of all cell keys.
   */
  public function getCellKeys(): array {
    return array_keys($this->cells);
  }

  /**
   * Returns the amount of cells in this row.
   *
   * @return int
   */
  public function getCellCount(): int {
    return count($this->cells);
  }

  /**
   * Returns the array representation.
   *
   * @return array
   */
  public function toArray(): array {
    $result = [
      'cells' => [], // Filled below.
      'attributes' => $this->getAttributes()->toArray(),
    ];

    if (!empty($this->cells)) {
      foreach ($this->cells as $key => $cell) {
        $result['#cells'][$key] = $cell->toArray();
      }
    }

    return $result;
  }
}
