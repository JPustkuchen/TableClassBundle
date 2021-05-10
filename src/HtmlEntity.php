<?php

namespace App\JPustkuchen\TableClassBundle;

use HtmlAttributes;

abstract class HtmlEntity {
  private array $attributes;

  public function __construct(?HtmlAttributes $attributes) {
    if (!empty($attributes)) {
      $this->setAttributes($attributes);
    } else {
      $this->setAttributes(new HtmlAttributes());
    }
  }



  /**
   * Return attributes.
   *
   * @return array
   */
  public function getAttributes(): array {
    return $this->attributes;
  }

  /**
   * Set the value of attributes
   *
   * @return  self
   */
  protected function setAttributes($attributes) {
    $this->attributes = $attributes;

    return $this;
  }
}
