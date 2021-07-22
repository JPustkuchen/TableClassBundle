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
   * @return static
   */
  private function setKey($key): static {
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
   * @return  static
   */
  public function setValue($value): static {
    $this->value = $value;

    return $this;
  }

  /**
   * Returns the array representation.
   *
   * @return array
   */
  public function toArray() {
    // TODO - make class changable from outside:
    if ($this->hidden) {
      // Add class 'hidden' if this is hidden:
      $this->getAttributes()->addClass('hidden');
    }

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
   * @return  static
   */
  public function setAfterValueRaw($afterValueRaw): static {
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
   * @return static
   */
  public function setBeforeValueRaw($beforeValueRaw): static {
    $this->beforeValueRaw = $beforeValueRaw;

    return $this;
  }

  /**
   * Set the cell hidden.
   *
   * @return  static
   */
  public function setHidden(bool $hidden): static {
    $this->hidden = $hidden;

    return $this;
  }

  /**
   * Get data purposes.
   *
   * @return  bool
   */
  public function isHidden() {
    return $this->hidden;
  }
}
