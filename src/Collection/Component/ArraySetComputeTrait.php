<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Collection;
use Fwolf\Common\Collection\CollectionInterface;

/**
 * Implement of {@link ArraySetComputeInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArraySetComputeTrait
{
    /**
     * Return collection of elements whose keys not in any of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function diffByKey(array $elements)
    {
        $resultAr = array_diff_key($this->elements, $elements);

        return new Collection($resultAr);
    }


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
    public function diffByKeyCompare(callable $func, array $elements)
    {
        $resultAr = array_diff_ukey($this->elements, $elements, $func);

        return new Collection($resultAr);
    }


    /**
     * Return collection of elements whose value not in any of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function diffByValue(array $elements)
    {
        $resultAr = array_diff($this->elements, $elements);

        return new Collection($resultAr);
    }


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
    public function diffByValueCompare(callable $func, array $elements)
    {
        $resultAr = array_udiff($this->elements, $elements, $func);

        return new Collection($resultAr);
    }


    /**
     * Return collection of elements whose keys also in all of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function intersectByKey(array $elements)
    {
        $resultAr = array_intersect_key($this->elements, $elements);

        return new Collection($resultAr);
    }


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
    public function intersectByKeyCompare(callable $func, array $elements)
    {
        $resultAr = array_intersect_ukey($this->elements, $elements, $func);

        return new Collection($resultAr);
    }


    /**
     * Return collection of elements whose value also in all of given collection
     *
     * @param   array $elements
     * @return  CollectionInterface
     */
    public function intersectByValue(array $elements)
    {
        $resultAr = array_intersect($this->elements, $elements);

        return new Collection($resultAr);
    }


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
    public function intersectByValueCompare(callable $func, array $elements)
    {
        $resultAr = array_uintersect($this->elements, $elements, $func);

        return new Collection($resultAr);
    }


    /**
     * Merge another collection with this
     *
     * Value with same assoc key from merge source will overwrite exists value,
     * same with array_merge().
     *
     * @param   array $elements
     * @return  $this
     */
    public function merge(array $elements)
    {
        $this->elements = array_merge($this->elements, $elements);

        return $this;
    }


    /**
     * Extract a slice of collection
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @return  CollectionInterface
     */
    public function slice($offset, $length = null)
    {
        $elements = array_slice($this->elements, $offset, $length);

        return new Collection($elements);
    }


    /**
     * Delete a slice from collection and replace by given data
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @param   array    $replacement
     * @return  CollectionInterface Deleted elements.
     */
    public function splice($offset, $length = null, $replacement = [])
    {
        if (is_null($length)) {
            $length = count($this->elements);
        }

        if (empty($replacement)) {
            $elements = array_splice($this->elements, $offset, $length);

        } else {
            // Try to keep key of $replacement
            $headPart = array_slice($this->elements, 0, $offset);
            $tailPart = array_slice($this->elements, $offset + $length);

            $elements = array_splice($this->elements, $offset, $length);

            $this->elements = array_merge($headPart, $replacement);
            // If same key in replacement and tailPart, it will use position in
            // replacement, as new inserted.
            $tailPart = array_merge($tailPart, $replacement);
            $this->elements = $this->elements + $tailPart;
        }

        return new Collection($elements);
    }


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
    public function split(callable $predicate)
    {
        $passed = new Collection();
        $failed = new Collection();

        foreach ($this->elements as $key => $element) {
            if ($predicate($element)) {
                $passed->set($key, $element);
            } else {
                $failed->set($key, $element);
            }
        }

        return [$passed, $failed];
    }


    /**
     * Union with given collections
     *
     * Key already exists will NOT be overwrite by same key in given collection,
     * same with array '+' operator.
     *
     * @param   array $elements
     * @return  $this
     */
    public function union(array $elements)
    {
        $this->elements = $this->elements + $elements;

        return $this;
    }
}
