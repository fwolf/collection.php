<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of {@link TypedArraySetComputeInterface}
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
trait TypedArraySetComputeTrait
{
    use ArraySetComputeTrait;


    /**
     * Return collection of elements whose keys not in any of given collection
     *
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function diffByKey(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_diff_key($this->elements, $elements);

        return $this->createCollection($resultAr);
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
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function diffByKeyCompare(callable $func, array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_diff_ukey($this->elements, $elements, $func);

        return $this->createCollection($resultAr);
    }


    /**
     * Return collection of elements whose value not in any of given
     * collection
     *
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function diffByValue(array $elements)
    {
        return $this->diffByValueCompare(
            [$this, 'compareElement'],
            $elements
        );
    }


    /**
     * Return collection of elements whose value not in any of given
     * collection
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
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function diffByValueCompare(callable $func, array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_udiff($this->elements, $elements, $func);

        return $this->createCollection($resultAr);
    }


    /**
     * Return collection of elements whose keys also in all of given
     * collection
     *
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function intersectByKey(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_intersect_key($this->elements, $elements);

        return $this->createCollection($resultAr);
    }


    /**
     * Return collection of elements whose keys also in all of given
     * collection
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
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function intersectByKeyCompare(callable $func, array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_intersect_ukey($this->elements, $elements, $func);

        return $this->createCollection($resultAr);
    }


    /**
     * Return collection of elements whose value also in all of given
     * collection
     *
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function intersectByValue(array $elements)
    {
        return $this->intersectByValueCompare(
            [$this, 'compareElement'],
            $elements
        );
    }


    /**
     * Return collection of elements whose value also in all of given
     * collection
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
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function intersectByValueCompare(callable $func, array $elements)
    {
        $this->assertAllowedTypes($elements);

        $resultAr = array_uintersect($this->elements, $elements, $func);

        return $this->createCollection($resultAr);
    }


    /**
     * Merge another collection with this
     *
     * Value with same assoc key from merge source will overwrite exists
     * value, same with array_merge().
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function merge(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $this->elements = array_merge($this->elements, $elements);

        return $this;
    }


    /**
     * Extract a slice of collection
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @return  TypedCollectionInterface
     */
    public function slice($offset, $length = null)
    {
        $elements = array_slice($this->elements, $offset, $length, true);

        return $this->createCollection($elements);
    }


    /**
     * Delete a slice from collection and replace by given data
     *
     * @param   int      $offset
     * @param   int|null $length Null meas to end of collection.
     * @param   object[] $replacement
     * @return  TypedCollectionInterface Deleted elements.
     */
    public function splice($offset, $length = null, $replacement = [])
    {
        if (is_null($length)) {
            $length = count($this->elements);
        }

        if (empty($replacement)) {
            $elements = array_splice($this->elements, $offset, $length);
        } else {
            $this->assertAllowedTypes($replacement);

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

        return $this->createCollection($elements);
    }


    /**
     * Split collection to two, by predicate
     *
     * Result collection has 2 element, 1st element is collection of elements
     * which the predicate return true, and 2nd element is collection of
     * elements with false predicate result.
     *
     * @param   callable $predicate Take element as first parameter
     * @return  TypedCollectionInterface[]
     */
    public function split(callable $predicate)
    {
        $passed = $this->createCollection();
        $failed = $this->createCollection();

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
     * Key already exists will NOT be overwrite by same key in given
     * collection, same with array '+' operator.
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function union(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $this->elements = $this->elements + $elements;

        return $this;
    }
}
