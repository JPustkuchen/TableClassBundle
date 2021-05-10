<?php

namespace JPustkuchen\TableClassBundle\Elements;

abstract class HtmlEntity {
  /**
   * The HTML Attributes object.
   */
  private HtmlAttributes $attributes;

  public function __construct(?HtmlAttributes $attributes) {
    if (!empty($attributes)) {
      $this->setAttributes($attributes);
    } else {
      $this->setAttributes(new HtmlAttributes());
    }
  }

  /**
   * Sets an attribute.
   *
   * @param string $name
   * @param mixed] $value
   * @return HtmlEntity
   */
  public function setAttribute(string $name, $value): HtmlEntity{
    $this->getAttributes()->setAttribute($name, $value);

    return $this;
  }

  /**
   * Adds all classes from array.
   *
   * @param array $classes
   * @return HtmlEntity
   */
  public function addClassesFromArray(array $classes): HtmlEntity{
    $this->getAttributes()->addClassesFromArray($classes);

    return $this;
  }


  /**
   * Adds a class.
   *
   * @param string $class
   * @return HtmlEntity
   */
  public function addClass(string $class): HtmlEntity {
    $this->getAttributes()->addClass($class);

    return $this;
  }

  /**
   * Return attributes.
   *
   * @return HtmlAttributes
   */
  public function getAttributes(): HtmlAttributes {
    return $this->attributes;
  }

  /**
   * Set attributes object.
   *
   * @param HtmlAttributes $attributes
   */
  protected function setAttributes(HtmlAttributes $attributes): HtmlEntity {
    $this->attributes = $attributes;

    return $this;
  }
}
