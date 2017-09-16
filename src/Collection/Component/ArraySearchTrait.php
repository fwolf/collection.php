<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Collection;
use Fwolf\Common\Collection\CollectionInterface;

/**
 * Implement of {@link ArraySearchInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArraySearchTrait
{
    /**
     * Check if all elements satisfies given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  bool
     */
    public function every(callable $predicate)
    {
        foreach ($this->elements as $element) {
            if (false == $predicate($element)) {
                return false;
            }
        }

        return true;
    }


    /**
     * Check if any element satisfies given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  bool
     */
    public function exists(callable $predicate)
    {
        foreach ($this->elements as $element) {
            if (true == $predicate($element)) {
                return true;
            }
        }

        return false;
    }


    /**
     * Remove elements fail given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  $this
     */
    public function filter(callable $predicate)
    {
        foreach ($this->elements as $key => $element) {
            if (false == $predicate($element)) {
                unset($this->elements[$key]);
            }
        }

        return $this;
    }


    /**
     * Check if collection have given element
     *
     * If element is complicate type, this search may not accurate as lack of
     * element equal compute.
     *
     * @param   mixed $element
     * @return  bool
     */
    public function hasElement($element)
    {
        return false !== $this->indexOf($element);
    }


    /**
     * Check if collection have given key
     *
     * @param   string|int $key
     * @return  bool
     */
    public function hasKey($key)
    {
        return array_key_exists($key, $this->elements);
    }


    /**
     * Find key of given element
     *
     * @param   mixed $element
     * @return  string|int|bool Return false when not found.
     */
    public function indexOf($element)
    {
        return array_search($element, $this->elements);
    }


    /**
     * Get collection of elements satisfy given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  CollectionInterface
     */
    public function matching(callable $predicate)
    {
        $matched = new Collection();

        foreach ($this->elements as $key => $element) {
            if (true == $predicate($element)) {
                $matched->set($key, $element);
            }
        }

        return $matched;
    }
}
