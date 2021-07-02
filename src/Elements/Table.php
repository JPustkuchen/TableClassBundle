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
     * @return Table
     */
    public function setHeaderFromArray(array $headerArray): Table {
        $this->setHeader(TableRow::createFromArray($headerArray));
        return $this;
    }

    /**
     * Adds rows from an array of indexed arrays.
     *
     * @param array $rowsArray
     * @return Table
     */
    public function addRowsFromArray(array $rowsArray): Table {
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
     * @return Table
     */
    public function addRow(TableRow $row): Table {
        $this->rows[] = $row;
        return $this;
    }

    /**
     * Sets the header.
     *
     * @param TableRow $header
     * @return Table
     */
    public function setHeader(TableRow $header): Table {
        $this->header = $header;
        return $this;
    }

    /**
     * Sets the rows.
     *
     * @param array $rows
     * @return Table
     */
    public function setRows(array $rows = []): Table {
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
     * @return Table
     */
    public function removeHeaderlessColumns(): Table {
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
     * @return Table
     */
    public function hideHeaderlessColumns(): Table {
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
    public function getHeader(): TableRow
    {
        return $this->header;
    }

    /**
     * Get all further rows.
     *
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }
}
