<?php

namespace JPustkuchen\TableClassBundle\Elements;

abstract class HtmlEntity {
  /**
   * The HTML Attributes object.
   */
  private HtmlAttributes $attributes;

  public function __construct(?HtmlAttributes $attributes = null) {
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
   * @param mixed $value
   * @return static
   */
  public function setAttribute(string $name, $value): static{
    $this->getAttributes()->setAttribute($name, $value);
    return $this;
  }

  /**
   * Adds all classes from array.
   *
   * @param array $classes
   * @return static
   */
  public function addClassesFromArray(array $classes): static{
    $this->getAttributes()->addClassesFromArray($classes);

    return $this;
  }


  /**
   * Adds a class.
   *
   * @param string $class
   * @return static
   */
  public function addClass(string $class): static {
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
   * @return static
   */
  protected function setAttributes(HtmlAttributes $attributes): static {
    $this->attributes = $attributes;
    return $this;
  }
}
