<?php

namespace Fwolf\Common\Collection\Component;

/**
 * Sort operate of collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArraySortInterface
{
    /**
     * Change elements to reverse order
     *
     * @return  $this
     */
    public function reverse();


    /**
     * Shuffle elements
     *
     * @return  $this
     */
    public function shuffle();


    /**
     * Sort element by key, ascending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByKey($flag = SORT_REGULAR);


    /**
     * Sort element by compare key with callable function
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
     * @return  $this
     */
    public function sortByKeyCompare(callable $func);


    /**
     * Sort element by key, descending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByKeyReversed($flag = SORT_REGULAR);


    /**
     * Sort element by value, ascending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByValue($flag = SORT_REGULAR);


    /**
     * Sort element by compare value with callable function
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
     * @return  $this
     */
    public function sortByValueCompare(callable $func);


    /**
     * Sort element by value, descending order
     *
     * @param   int $flag
     * @return  $this
     */
    public function sortByValueReversed($flag = SORT_REGULAR);


    /**
     * Remove duplicate element in collection
     *
     * @param   int $flag
     * @return  $this
     */
    public function unique($flag = SORT_STRING);
}
