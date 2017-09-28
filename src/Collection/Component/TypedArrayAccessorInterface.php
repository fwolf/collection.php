<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Simple accessor methods for collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface TypedArrayAccessorInterface extends ArrayAccessorInterface
{
    /**
     * Alias of append()
     *
     * @param   object $element
     * @return  $this
     */
    public function add($element);


    /**
     * Add an element at end of collection
     *
     * @param   object $element
     * @return  $this
     */
    public function append($element);


    /**
     * Add elements at end of collection
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function appendMultiple(array $elements);


    /**
     * Get element of given key
     *
     * @param   string|int $key
     * @return  object
     */
    public function get($key);


    /**
     * Get all keys of collection
     *
     * @return  string[]|int[]
     */
    public function getKeys();


    /**
     * Get element of given key, if fail, return default
     *
     * @param   string|int $key
     * @param   object     $default
     * @return  object
     */
    public function getOrDefault($key, $default);


    /**
     * Get all values of collection
     *
     * Result's key will be re-numbered by raw position.
     *
     * @return  object[]    Its NOT assoc by identity anymore
     */
    public function getValues();


    /**
     * Pick elements to new collection by given keys
     *
     * @param   string[]|int[] $keys
     * @return  TypedCollectionInterface
     */
    public function pick(array $keys);


    /**
     * Remove element from end and return removed element
     *
     * @return  object
     */
    public function pop();


    /**
     * Remove multiple elements from end and return removed element
     *
     * @param   int $count
     * @return  TypedCollectionInterface
     */
    public function popMultiple($count);


    /**
     * Add an element at begin of collection
     *
     * @param   object $element
     * @return  $this
     */
    public function prepend($element);


    /**
     * Add elements at begin of collection
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function prependMultiple(array $elements);


    /**
     * Get a random element
     *
     * @return  object
     */
    public function randomElement();


    /**
     * Get specified number of random elements
     *
     * @param   int $count
     * @return  TypedCollectionInterface
     */
    public function randomElements($count);


    /**
     * Remove element by its value
     *
     * @param   object $element
     * @return  $this
     */
    public function removeElement($element);


    /**
     * Remove elements by their value
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function removeElements(array $elements);


    /**
     * Set/update element of given key
     *
     * Will check if key belongs to element.
     *
     * @param   string|int $key
     * @param   object     $element
     * @return  $this
     */
    public function set($key, $element);


    /**
     * Remove element from beginning and return removed element
     *
     * @return  object
     */
    public function shift();


    /**
     * Remove multiple elements from beginning and return removed element
     *
     * @param   int $count
     * @return  TypedCollectionInterface
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
     * @return  TypedCollectionInterface
     */
    public function take(array $keys);
}
