<?php

namespace JPustkuchen\TableClassBundle\Elements;

/**
 * Reprecents an HTML Table Cell.
 */
class TableCell extends HtmlEntity {
  /**
   * Cell column key.
   */
  private string $key;

  /**
   * Cell value.
   */
  private ?string $value = null;

  /**
   * Raw content to prepend to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   */
  private ?string $beforeValueRaw = null;

  /**
   * Raw content to append to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   */
  private ?string $afterValueRaw = null;

  /**
   * Defines the cell as hidden.
   * Helpfull to allow "pseudo" cells for
   * data purposes.
   *
   * @var bool
   */
  private $hidden = false;


  public function __construct(string $key, ?string $value = null, ?HtmlAttributes $attributes = null) {
    $this->key = $key;
    $this->value = $value;
    parent::__construct($attributes);
  }

  /**
   * Get the value of key
   */
  public function getKey() {
    return $this->key;
  }

  /**
   * Set the value of key.
   *
   * @return  self
   */
  private function setKey($key) {
    $this->key = $key;

    return $this;
  }

  /**
   * Get the value of value.
   */
  public function getValue() {
    return $this->value;
  }

  /**
   * Set the value of value.
   *
   * @return  self
   */
  public function setValue($value) {
    $this->value = $value;

    return $this;
  }

  /**
   * Returns the array representation.
   *
   * @return array
   */
  public function toArray() {
    $result = [
      'key' => $this->key,
      'value' => $this->value,
      'beforeValueRaw' => $this->beforeValueRaw,
      'afterValueRaw' => $this->afterValueRaw,
      'attributes' => $this->getAttributes()->toString(),
      'hidden' => $this->hidden,
    ];

    return $result;
  }

  /**
   * Get raw content to append to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   */
  public function getAfterValueRaw() {
    return $this->afterValueRaw;
  }

  /**
   * Set raw content to append to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   *
   * @return  self
   */
  public function setAfterValueRaw($afterValueRaw) {
    $this->afterValueRaw = $afterValueRaw;

    return $this;
  }

  /**
   * Get raw content to prepend to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   */
  public function getBeforeValueRaw() {
    return $this->beforeValueRaw;
  }

  /**
   * Set raw content to prepend to value.
   * Use with care and not for user input!
   * This will not be auto-escaped!
   *
   * @return  self
   */
  public function setBeforeValueRaw($beforeValueRaw) {
    $this->beforeValueRaw = $beforeValueRaw;

    return $this;
  }

  /**
   * Set the cell hidden.
   *
   * @return  self
   */
  public function setHidden(bool $hidden)
  {
    $this->hidden = $hidden;

    return $this;
  }
}
