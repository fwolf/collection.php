<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\CollectionInterface;

/**
 * Search relate methods for collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArraySearchInterface
{
    /**
     * Check if all elements satisfies given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  bool
     */
    public function every(callable $predicate);


    /**
     * Check if any element satisfies given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  bool
     */
    public function exists(callable $predicate);


    /**
     * Remove elements fail given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  $this
     */
    public function filter(callable $predicate);


    /**
     * Check if collection have given element
     *
     * If element is complicate type, this search may not accurate as lack of
     * element equal compute.
     *
     * @param   mixed $element
     * @return  bool
     */
    public function hasElement($element);


    /**
     * Check if collection have given key
     *
     * @param   string|int $key
     * @return  bool
     */
    public function hasKey($key);


    /**
     * Find key of given element
     *
     * @param   mixed $element
     * @return  string|int|bool Return false when not found.
     */
    public function indexOf($element);


    /**
     * Get collection of elements satisfy given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  CollectionInterface
     */
    public function matching(callable $predicate);
}
