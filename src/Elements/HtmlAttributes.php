<?php

namespace JPustkuchen\TableClassBundle\Elements;

class HtmlAttributes implements \ArrayAccess, \IteratorAggregate {

  /**
   * Array of HTML Attributes in array structure.
   */
  private array $attributes = [];

  /**
   * Represents the HTML class attribute, which is treated as special case.
   */
  const HTML_ATTRIBUTE_CLASS = 'class';

  /**
   * Constructor.
   *
   * @param array $attributes
   */
  public function __construct(array $attributes = []) {
    $this->attributes = ['class' => []];
    foreach ($attributes as $name => $value) {
      $this->setAttribute($name, $value);
    }
  }

  /**
   * Returns attribute by name.
   *
   * @param string] $name
   */
  public function getAttribute(string $name) {
    return $this->offsetGet($name);
  }

  /**
   * Returns the whole attribute array.
   *
   * @return array
   */
  public function getAttributes(): array {
    return $this->attributes;
  }

  /**
   * Sets an attribute.
   *
   * @param string $name
   * @param mixed] $value
   * @return HtmlAttributes
   */
  public function setAttribute(string $name, $value): HtmlAttributes {
    $this
      ->offsetSet($name, $value);
    return $this;
  }

  /**
   * Removes an attribute.
   *
   * @param string $name
   * @return HtmlAttributes
   */
  public function removeAttribute(string $name): HtmlAttributes {
    $this->offsetUnset($name);
    return $this;
  }

  /**
   * Returns true if an attribute with the given name exists, else false.
   *
   * @param string $name
   * @return bool
   */
  public function hasAttribute(string $name): bool {
    return $this->offsetExists($name);
  }

  /**
   * Returns all class vallues.
   *
   * @return array
   */
  public function getClasses(): array {
    return $this->getAttribute(self::HTML_ATTRIBUTE_CLASS);
  }

  /**
   * Adds all classes from array.
   *
   * @param array $classes
   * @return HtmlAttributes
   */
  public function addClassesFromArray(array $classes): HtmlAttributes{
    if(!empty($classes)){
      foreach($classes as $class){
        $this->addClass($class);
      }
    }

    return $this;
  }

  /**
   * Adds a class.
   *
   * @param string $class
   * @return HtmlAttributes
   */
  public function addClass(string $class): HtmlAttributes {
    $classes = $this->getClasses();
    if (empty($classes)) {
      $classes = [];
    }
    $classes[] = $class;
    $this->setAttribute(self::HTML_ATTRIBUTE_CLASS, array_unique($classes));

    return $this;
  }

  /**
   * Removes a class.
   *
   * @param string $class
   * @return HtmlAttributes
   */
  public function removeClass(string $class): HtmlAttributes {
    if ($this->hasClass($class)) {
      $classes = $this->getClasses();
      unset($classes[$class]);
      $this->setAttribute(self::HTML_ATTRIBUTE_CLASS, $classes);
    }
    return $this;
  }

  /**
   * Returns true if the class exists, else false.
   *
   * @param string $class
   * @return bool
   */
  public function hasClass(string $class): bool {
    if ($this->hasAttribute(self::HTML_ATTRIBUTE_CLASS)) {
      $classes = $this->getClasses();
      return isset($classes[$class]);
    }
    return false;
  }

  /**
   * Returns the HTML string representation.
   */
  public function toString() {
    $string = '';
    $attributes = $this->getAttributes();
    foreach ($attributes as $name => $value) {
      if (is_bool($value)) {
        if ($value) $string .= $name . ' ';
      } elseif (is_array($value)) {
        $string .= sprintf('%s="%s"', $name, implode(' ', $value));
      } else {
        $string .= sprintf('%s="%s"', $name, $value);
      }
    }
    return $string;
  }

  /**
   * Returns the array representation.
   */
  public function toArray() {
    return $this->getAttributes();
  }

  /**
   * {@inheritdoc}
   */
  public function offsetGet($name) {
    if (isset($this->attributes[$name])) {
      return $this->attributes[$name];
    }
  }

  /**
   * {@inheritdoc}
   */
  public function offsetSet($name, $value) {
    $this->attributes[$name] = $value;
  }

  /**
   * {@inheritdoc}
   */
  public function offsetUnset($name) {
    unset($this->attributes[$name]);
  }

  /**
   * {@inheritdoc}
   */
  public function offsetExists($name) {
    return isset($this->attributes[$name]);
  }

  /**
   * Implements the magic __toString() method.
   */
  public function __toString() {
    return $this->toString();
  }

  /**
   * Implements the magic __clone() method.
   */
  public function __clone() {
    foreach ($this->attributes as $name => $value) {
      $this->attributes[$name] = clone $value;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new \ArrayIterator($this->attributes);
  }
}
