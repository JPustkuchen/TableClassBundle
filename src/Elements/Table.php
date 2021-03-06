<?php

namespace JPustkuchen\TableClassBundle\Elements;

use Twig\Environment;

/**
 * Reprecents a (vertical) HTML Table.
 */
class Table extends HtmlEntity {

    /**
     * Twig environment.
     */
    private Environment $twig;

    /**
     * The table header row.
     */
    private TableRow $header;

    /**
     * All further rows.
     */
    private array $rows;

    /**
     * Constructor.
     *
     * @param Environment $twig
     * @param TableRow|null $header
     * @param array $rows
     * @param HtmlAttributes|null $attributes
     */
    public function __construct(Environment $twig, ?TableRow $header = null, array $rows = [], ?HtmlAttributes $attributes = null) {
        $this->twig = $twig;
        if ($header === null) {
            $header = new TableRow();
        }
        $this->setHeader($header);
        $this->setRows($rows);
        parent::__construct($attributes);
    }

    /**
     * Creates the table header from an indexed array.
     *
     * @param array $headerArray
     * @return static
     */
    public function setHeaderFromArray(array $headerArray): static {
        $headerTableRow = TableRow::createFromArray($headerArray);
        // Hide rows with empty title (===null)
        $headerTableRow->iterateCells(function (TableCell $cell, $index) {
            if ($cell->getValue() === null) {
                $cell->setHidden(true);
            }
            return $cell;
        });
        $this->setHeader($headerTableRow);
        return $this;
    }

    /**
     * Adds rows from an array of indexed arrays.
     *
     * @param array $rowsArray
     * @return static
     */
    public function addRowsFromArray(array $rowsArray): static {
        if (!empty($rowsArray)) {
            foreach ($rowsArray as $rowArray) {
                $this->addRow(TableRow::createFromArray($rowArray));
            }
        }
        return $this;
    }

    /**
     * Adds a single row.
     *
     * @param TableRow $row
     * @return static
     */
    public function addRow(TableRow $row): static {
        $this->rows[] = $row;
        return $this;
    }

    /**
     * Sets the header.
     *
     * @param TableRow $header
     * @return static
     */
    public function setHeader(TableRow $header): static {
        $this->header = $header;
        return $this;
    }

    /**
     * Sets the rows.
     *
     * @param array $rows
     * @return static
     */
    public function setRows(array $rows = []): static {
        $this->rows = [];
        if (!empty($rows)) {
            foreach ($rows as $row) {
                $this->addRow($row);
            }
        }
        return $this;
    }

    /**
     * Run the given lambda function on all rows.
     * Use with care!
     *
     * @param [type] $lambda
     */
    public function iterateRows(callable $lambda) {
        foreach ($this->rows as $index => $row) {
            $this->rows[$index] = $lambda($row, $index);
        }
    }

    /**
     * Returns the array representation.
     *
     * @return array
     */
    public function toArray(): array {
        $result = [
            'header' => $this->header->toArray(),
            'rows' => [],
            'attributes' => $this->getAttributes()->toString(),
        ];
        if (!empty($this->rows)) {
            foreach ($this->rows as $row) {
                $result['rows'][] = $row->toArray();
            }
        }
        return $result;
    }

    /**
     * Returns the rendered
     */
    public function render() {
        return $this->twig->render('@JPustkuchenTableClass/table.html.twig', [
            'tabledata' => $this->toArray()
        ]);
    }

    /**
     * Helper function to remove headerless columns from all rows.
     * You may for example find this useful when using
     * setHeaderFromArray() + addRowsFromArray() with different array sizes.
     *
     * Only useful if header was set before.
     *
     * @return static
     */
    public function removeHeaderlessColumns(): static {
        $cellKeys = $this->header->getCellKeys();
        if (!empty($this->rows) && !empty($cellKeys)) {
            foreach ($this->rows as $row) {
                $cells = $row->getCells();
                foreach ($cells as $cell) {
                    $cellKey = $cell->getKey();
                    if (!in_array($cellKey, $cellKeys)) {
                        $row->removeCell($cellKey);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Helper function to hide headerless columns from all rows in twig output.
     * You may for example find this useful when using
     * setHeaderFromArray() + addRowsFromArray() with different array sizes.
     *
     * Only useful if header was set before.
     *
     * This
     * @param stromg $class The class name to hide the cell.
     * @return static
     */
    public function hideHeaderlessColumns(): static {
        // Exclude hidden (value === null) header cells.
        $cellKeys = $this->header->getCellKeys(true);
        if (!empty($this->rows) && !empty($cellKeys)) {
            foreach ($this->rows as $row) {
                $cells = $row->getCells();
                foreach ($cells as $cell) {
                    $cellKey = $cell->getKey();
                    if (!in_array($cellKey, $cellKeys)) {
                        $cell->setHidden(true);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Get the table header row.
     *
     * @return TableRow
     */
    public function getHeader(): TableRow {
        return $this->header;
    }

    /**
     * Get all further rows.
     *
     * @return array
     */
    public function getRows(): array {
        return $this->rows;
    }
}
