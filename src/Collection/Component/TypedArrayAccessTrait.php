<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of ArrayAccess interface
 *
 * @link        http://php.net/manual/en/class.arrayaccess.php
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
trait TypedArrayAccessTrait
{
    use ArrayAccessTrait;


    /**
     * Offset to retrieve
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetget.php
     * @param   string|int $offset
     * @return  object
     */
    public function offsetGet($offset)
    {
        return $this->elements[$offset];
    }


    /**
     * Offset to set
     *
     * @link    http://php.net/manual/en/arrayaccess.offsetset.php
     * @param   string|int $offset
     * @param   object     $value
     * @return  void
     */
    public function offsetSet($offset, $value)
    {
        $this->assertAllowedType($value);

        $this->elements[$offset] = $value;
    }
}
