<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of {@link TypedArraySortInterface}
 *
 * @property    object[] $elements
 * @method      $this assertAllowedType($element)
 * @method      $this assertAllowedTypes(array $elements)
 * @method      int compareElement($element1, $element2)
 * @method      TypedCollectionInterface createCollection(array $items = [])
 * @method      string|int getElementIdentity($element)
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedArraySortTrait
{
    use ArraySortTrait;


    /**
     * Shuffle elements
     *
     * @return  $this
     */
    public function shuffle()
    {
        $keys = array_keys($this->elements);
        shuffle($keys);

        $elements = [];
        foreach ($keys as $key) {
            $elements[$key] = $this->elements[$key];
        }

        $this->elements = $elements;

        return $this;
    }


    /**
     * Sort element by value, ascending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByValue($flag = SORT_REGULAR)
    {
        uasort($this->elements, [$this, 'compareElement']);

        return $this;
    }


    /**
     * Sort element by value, descending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByValueReversed($flag = SORT_REGULAR)
    {
        $this->sortByValue($flag)
            ->reverse();

        return $this;
    }


    /**
     * Remove duplicate element in collection
     *
     * @param   int $flag
     * @return  $this
     */
    public function unique($flag = SORT_STRING)
    {
        // As identity is key of elements, so its always unique
        false && $flag;

        return $this;
    }
}
