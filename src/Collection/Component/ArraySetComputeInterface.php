<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\CollectionInterface;

/**
 * Set compute/operate of collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArraySetComputeInterface
{
    /**
     * Return collection of elements whose keys not in any of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function diffByKey(array $elements);


    /**
     * Return collection of elements whose keys not in any of given collection
     *
     * With given compare function.
     *
     * Compare function take two key(a, b) as parameters, it returns
     *
     *  - -1 when a < b
     *  -  0 when a = b
     *  -  1 when a > b
     *
     * If a < b, then a will sort before b in result.
     *
     * @param   callable $func
     * @param   array    $elements
     * @return  CollectionInterface
     */
    public function diffByKeyCompare(callable $func, array $elements);


    /**
     * Return collection of elements whose value not in any of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function diffByValue(array $elements);


    /**
     * Return collection of elements whose value not in any of given collection
     *
     * With given compare function.
     *
     * Compare function take two element(a, b) as parameters, it returns
     *
     *  - -1 when a < b
     *  -  0 when a = b
     *  -  1 when a > b
     *
     * If a < b, then a will sort before b in result.
     *
     * @param   callable $func
     * @param   array    $elements
     * @return  CollectionInterface
     */
    public function diffByValueCompare(callable $func, array $elements);


    /**
     * Return collection of elements whose keys also in all of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function intersectByKey(array $elements);


    /**
     * Return collection of elements whose keys also in all of given collection
     *
     * With given compare function.
     *
     * Compare function take two key(a, b) as parameters, it returns
     *
     *  - -1 when a < b
     *  -  0 when a = b
     *  -  1 when a > b
     *
     * If a < b, then a will sort before b in result.
     *
     * @param   callable $func
     * @param   array    $elements
     * @return  CollectionInterface
     */
    public function intersectByKeyCompare(callable $func, array $elements);


    /**
     * Return collection of elements whose value also in all of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function intersectByValue(array $elements);


    /**
     * Return collection of elements whose value also in all of given collection
     *
     * With given compare function.
     *
     * Compare function take two element(a, b) as parameters, it returns
     *
     *  - -1 when a < b
     *  -  0 when a = b
     *  -  1 when a > b
     *
     * If a < b, then a will sort before b in result.
     *
     * @param   callable $func
     * @param   array    $elements
     * @return  CollectionInterface
     */
    public function intersectByValueCompare(callable $func, array $elements);


    /**
     * Merge another collection with this
     *
     * Value with same assoc key from merge source will overwrite exists value,
     * same with array_merge().
     *
     * @param   array $elements
     * @return  $this
     */
    public function merge(array $elements);


    /**
     * Extract a slice of collection
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @return  CollectionInterface
     */
    public function slice($offset, $length = null);


    /**
     * Delete a slice from collection and replace by given data
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @param   array    $replacement
     * @return  CollectionInterface Deleted elements.
     */
    public function splice($offset, $length = null, $replacement = []);


    /**
     * Split collection to two, by predicate
     *
     * Result collection has 2 element, 1st element is collection of elements
     * which the predicate return true, and 2nd element is collection of
     * elements with false predicate result.
     *
     * @param   callable $predicate Take element as first parameter
     * @return  CollectionInterface[]
     */
    public function split(callable $predicate);


    /**
     * Union with given collections
     *
     * Key already exists will NOT be overwrite by same key in given collection,
     * same with array '+' operator.
     *
     * @param   array $elements
     * @return  $this
     */
    public function union(array $elements);
}
