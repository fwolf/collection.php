<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\CollectionInterface;
use Fwolf\Common\Collection\Exception\ExceedCollectionSizeException;
use Fwolf\Common\Collection\Exception\KeyNotFoundException;

/**
 * Implement of {@link ArrayAccessorInterface}
 *
 * @property    array $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait ArrayAccessorTrait
{
    /**
     * Alias of append()
     *
     * @param   mixed $element
     * @return  $this
     */
    public function add($element)
    {
        $this->append($element);

        return $this;
    }


    /**
     * Add an element at end of collection
     *
     * @param   mixed $element
     * @return  $this
     */
    public function append($element)
    {
        $this->elements[] = $element;

        return $this;
    }


    /**
     * Add elements at end of collection
     *
     * @param   array $elements
     * @return  $this
     */
    public function appendMultiple(array $elements)
    {
        foreach ($elements as $element) {
            $this->elements[] = $element;
        }

        return $this;
    }


    /**
     * Empty collection, remove all elements
     *
     * @return  $this
     */
    public function clear()
    {
        $this->elements = [];

        return $this;
    }


    /**
     * Get element of given key
     *
     * @param   string|int $key
     * @return  mixed
     * @throws  KeyNotFoundException
     */
    public function get($key)
    {
        if (!array_key_exists($key, $this->elements)) {
            throw new KeyNotFoundException();
        }

        return $this->elements[$key];
    }


    /**
     * Get all keys of collection
     *
     * @return  array
     */
    public function getKeys()
    {
        return array_keys($this->elements);
    }


    /**
     * Get element of given key, if fail, return default
     *
     * @param   string|int $key
     * @param   mixed      $default
     * @return  mixed
     */
    public function getOrDefault($key, $default)
    {
        if (!array_key_exists($key, $this->elements)) {
            return $default;
        }

        return $this->elements[$key];
    }


    /**
     * Get all values of collection
     *
     * Result's key will be re-numbered by raw position.
     *
     * @return  array
     */
    public function getValues()
    {
        return array_values($this->elements);
    }


    /**
     * If collection is empty
     *
     * @return  bool
     */
    public function isEmpty()
    {
        return 0 == count($this->elements);
    }


    /**
     * If collection is NOT empty
     *
     * @return  bool
     */
    public function isNotEmpty()
    {
        return 0 != count($this->elements);
    }


    /**
     * Pick elements to new collection by given keys
     *
     * @param   string[]|int[] $keys
     * @return  CollectionInterface
     */
    public function pick(array $keys)
    {
        $dummyAr = array_fill_keys($keys, null);

        $picked = array_intersect_key($this->elements, $dummyAr);

        $class = get_called_class();

        return new $class($picked);
    }


    /**
     * Remove element from end and return removed element
     *
     * @return  mixed
     */
    public function pop()
    {
        return array_pop($this->elements);
    }


    /**
     * Remove multiple elements from end and return removed element
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function popMultiple($count)
    {
        $offset = count($this->elements) - $count;
        $class = get_called_class();

        if (0 >= $offset) {
            // All popped
            $popped = new $class($this->elements);

            $this->elements = [];

            return $popped;

        } else {
            $items = array_splice($this->elements, $offset);

            return new $class($items);
        }
    }


    /**
     * Add an element at begin of collection
     *
     * @param   mixed $element
     * @return  $this
     */
    public function prepend($element)
    {
        array_unshift($this->elements, $element);

        return $this;
    }


    /**
     * Add elements at begin of collection
     *
     * @param   array $elements
     * @return  $this
     */
    public function prependMultiple(array $elements)
    {
        $element = array_pop($elements);

        while (null !== $element) {
            array_unshift($this->elements, $element);
            $element = array_pop($elements);
        }

        return $this;
    }


    /**
     * Get a random element
     *
     * @return  mixed
     */
    public function randomElement()
    {
        return $this->elements[$this->randomKey()];
    }


    /**
     * Get specified number of random elements
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function randomElements($count)
    {
        $keys = $this->randomKeys($count);

        return $this->pick($keys);
    }


    /**
     * Get a random key
     *
     * Use {@link mt_rand()} for better rand.
     *
     * @return  string|int
     */
    public function randomKey()
    {
        $totalKeys = array_keys($this->elements);

        $key = $totalKeys[mt_rand(0, count($totalKeys) - 1)];

        return $key;
    }


    /**
     * Get specified number of random keys
     *
     * @param   int $count
     * @return  string[]|int[]
     * @throws  ExceedCollectionSizeException
     */
    public function randomKeys($count)
    {
        if ($count > count($this->elements)) {
            throw new ExceedCollectionSizeException(
                "Demand count $count exceeds collection size " .
                count($this->elements)
            );
        }

        $totalKeys = array_keys($this->elements);
        $keyCount = count($totalKeys);
        $keys = [];

        while (0 < $count) {
            $rand = mt_rand(0, count($totalKeys) - 1);

            $keys[] = $totalKeys[$rand];

            // Remove selected key and re-order array keys
            unset($totalKeys[$rand]);
            $totalKeys = array_values($totalKeys);
            $keyCount--;

            $count--;
        }

        return $keys;
    }


    /**
     * Remove element by its value
     *
     * @param   mixed $element
     * @return  $this
     */
    public function removeElement($element)
    {
        $key = array_search($element, $this->elements);

        if (false !== $key) {
            unset($this->elements[$key]);
        }

        return $this;
    }


    /**
     * Remove elements by their value
     *
     * @param   array $elements
     * @return  $this
     */
    public function removeElements(array $elements)
    {
        $this->elements = array_diff($this->elements, $elements);

        return $this;
    }


    /**
     * Remove element by given key
     *
     * @param   string|int $key
     * @return  $this
     */
    public function removeKey($key)
    {
        unset($this->elements[$key]);

        return $this;
    }


    /**
     * Remove elements by given keys
     *
     * @param   string[]|int[] $keys
     * @return  $this
     */
    public function removeKeys(array $keys)
    {
        $elements = array_fill_keys($keys, null);

        $this->elements = array_diff_key($this->elements, $elements);

        return $this;
    }


    /**
     * Set/update element of given key
     *
     * @param   string|int $key
     * @param   mixed      $value
     * @return  $this
     */
    public function set($key, $value)
    {
        $this->elements[$key] = $value;

        return $this;
    }


    /**
     * Remove element from beginning and return removed element
     *
     * @return  mixed
     */
    public function shift()
    {
        return array_shift($this->elements);
    }


    /**
     * Remove multiple elements from beginning and return removed element
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function shiftMultiple($count)
    {
        $class = get_called_class();

        if ($count >= count($this->elements)) {
            // All shifted
            $shifted = new $class($this->elements);

            $this->elements = [];

            return $shifted;

        } else {
            $items = array_splice($this->elements, 0, $count);

            return new $class($items);
        }
    }


    /**
     * Take elements off to new collection
     *
     * Taken elements will be removed from original collection.
     *
     * If only want to remove elements, use {@link removeElements()}.
     *
     * @param   string[]|int[] $keys
     * @return  CollectionInterface
     */
    public function take(array $keys)
    {
        $taken = $this->pick($keys);

        $this->removeKeys($keys);

        return $taken;
    }
}
