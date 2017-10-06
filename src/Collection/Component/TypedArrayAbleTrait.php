<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of {@link TypedArrayAbleInterface}
 *
 * @property    object[] $elements
 * @method      $this assertAllowedType($element)
 * @method      $this assertAllowedTypes(array $elements)
 * @method      int compareElement($element1, $element2)
 * @method      TypedCollectionInterface createCollection($elements = [])
 * @method      string|int getElementIdentity($element)
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedArrayAbleTrait
{
    /**
     * Load from PHP array, will clear present data
     *
     * @param   object[] $objects Array of allowed object
     * @return  $this
     */
    public function fromArray(array $objects)
    {
        $this->assertAllowedTypes($objects);

        $this->elements = $objects;

        return $this;
    }


    /**
     * To native PHP array of allowed object
     *
     * @return  object[]
     */
    public function toArray()
    {
        return $this->elements;
    }
}
