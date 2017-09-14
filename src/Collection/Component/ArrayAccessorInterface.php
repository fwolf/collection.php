<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\CollectionInterface;

/**
 * Simple accessor methods for collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface ArrayAccessorInterface
{
    /**
     * Alias of append()
     *
     * @param   mixed $element
     * @return  $this
     */
    public function add($element);


    /**
     * Add an element at end of collection
     *
     * @param   mixed $element
     * @return  $this
     */
    public function append($element);


    /**
     * Add elements at end of collection
     *
     * @param   array $elements
     * @return  $this
     */
    public function appendMultiple(array $elements);


    /**
     * Empty collection, remove all elements
     *
     * @return  $this
     */
    public function clear();


    /**
     * Get element of given key
     *
     * @param   string|int $key
     * @return  mixed
     */
    public function get($key);


    /**
     * Get all keys of collection
     *
     * @return  array
     */
    public function getKeys();


    /**
     * Get element of given key, if fail, return default
     *
     * @param   string|int $key
     * @param   mixed      $default
     * @return  mixed
     */
    public function getOrDefault($key, $default);


    /**
     * Get all values of collection
     *
     * Result's key will be re-numbered by raw position.
     *
     * @return  array
     */
    public function getValues();


    /**
     * If collection is empty
     *
     * @return  bool
     */
    public function isEmpty();


    /**
     * If collection is NOT empty
     *
     * @return  bool
     */
    public function isNotEmpty();


    /**
     * Pick elements to new collection by given keys
     *
     * @param   string[]|int[] $keys
     * @return  CollectionInterface
     */
    public function pick(array $keys);


    /**
     * Remove element from end and return removed element
     *
     * @return  mixed
     */
    public function pop();


    /**
     * Remove multiple elements from end and return removed element
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function popMultiple($count);


    /**
     * Add an element at begin of collection
     *
     * @param   mixed $element
     * @return  $this
     */
    public function prepend($element);


    /**
     * Add elements at begin of collection
     *
     * @param   array $elements
     * @return  $this
     */
    public function prependMultiple(array $elements);


    /**
     * Get a random element
     *
     * @return  mixed
     */
    public function randomElement();


    /**
     * Get specified number of random elements
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function randomElements($count);


    /**
     * Get a random key
     *
     * @return  string|int
     */
    public function randomKey();


    /**
     * Get specified number of random keys
     *
     * @param   int $count
     * @return  string[]|int[]
     */
    public function randomKeys($count);


    /**
     * Remove element by its value
     *
     * @param   mixed $element
     * @return  $this
     */
    public function removeElement($element);


    /**
     * Remove elements by their value
     *
     * @param   array $elements
     * @return  $this
     */
    public function removeElements(array $elements);


    /**
     * Remove element by given key
     *
     * @param   string|int $key
     * @return  $this
     */
    public function removeKey($key);


    /**
     * Remove elements by given keys
     *
     * @param   string[]|int[] $keys
     * @return  $this
     */
    public function removeKeys(array $keys);


    /**
     * Set/update element of given key
     *
     * @param   string|int $key
     * @param   mixed      $value
     * @return  $this
     */
    public function set($key, $value);


    /**
     * Remove element from beginning and return removed element
     *
     * @return  mixed
     */
    public function shift();


    /**
     * Remove multiple elements from beginning and return removed element
     *
     * @param   int $count
     * @return  CollectionInterface
     */
    public function shiftMultiple($count);


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
    public function take(array $keys);
}
