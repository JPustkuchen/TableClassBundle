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
  private ?string $value;

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
      'attributes' => $this->getAttributes()->toString(),
    ];

    return $result;
  }
}
