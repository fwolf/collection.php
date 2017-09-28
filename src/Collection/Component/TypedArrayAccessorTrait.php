<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Exception\KeyAndElementNotMatchException;
use Fwolf\Common\Collection\Exception\KeyNotFoundException;
use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of {@link TypedArrayAccessorInterface}
 *
 * @property    object[] $elements
 * @method      $this assertAllowedType($element)
 * @method      $this assertAllowedTypes(array $elements)
 * @method      int compareElement($element1, $element2)
 * @method      string|int getElementIdentity($element)
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedArrayAccessorTrait
{
    use ArrayAccessorTrait;


    /**
     * Alias of append()
     *
     * @param   object $element
     * @return  $this
     */
    public function add($element)
    {
        $this->append($element);

        return $this;
    }


    /**
     * Add an element at end? of collection
     *
     * In common new element will be end of collection, but if element already
     * in collection (same identity), will update in place, its key may not be
     * end of collection.
     *
     * @param   object $element
     * @return  $this
     */
    public function append($element)
    {
        $this->assertAllowedType($element);

        $identity = $this->getElementIdentity($element);

        $this->elements[$identity] = $element;

        return $this;
    }


    /**
     * Add elements at end? of collection
     *
     * Only elements did not exist in collection will append.
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function appendMultiple(array $elements)
    {
        $this->assertAllowedTypes($elements);

        // array_merge() will not overwrite same numeric key, do manually
        foreach ($elements as $element) {
            $identity = $this->getElementIdentity($element);
            $this->elements[$identity] = $element;
        }

        return $this;
    }


    /**
     * Get element of given key
     *
     * @param   string|int $key
     * @return  object
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
     * Get element of given key, if fail, return default
     *
     * @param   string|int  $key
     * @param   object|null $default Can be null
     * @return  object
     */
    public function getOrDefault($key, $default)
    {
        if (!is_null($default)) {
            $this->assertAllowedType($default);
        }

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
     * @return  object[]    Its NOT assoc by identity anymore
     */
    public function getValues()
    {
        return array_values($this->elements);
    }


    /**
     * Pick elements to new collection by given keys
     *
     * @param   string[]|int[] $keys
     * @return  TypedCollectionInterface
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
     * @return  object
     */
    public function pop()
    {
        return array_pop($this->elements);
    }


    /**
     * Remove multiple elements from end and return removed element
     *
     * @param   int $count
     * @return  TypedCollectionInterface
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
            $keys = $this->getKeys();
            $keys = array_splice($keys, $offset);

            return $this->take($keys);
        }
    }


    /**
     * Add an element at begin of collection
     *
     * If element already exists, it will update and move to begin.
     *
     * @param   object $element
     * @return  $this
     */
    public function prepend($element)
    {
        $this->assertAllowedType($element);

        $identity = $this->getElementIdentity($element);
        $this->elements = [$identity => $element] + $this->elements;

        return $this;
    }


    /**
     * Add elements at begin of collection
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function prependMultiple(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $newElements = [];
        foreach ($elements as $element) {
            $identity = $this->getElementIdentity($element);
            $newElements[$identity] = $element;
        }

        $this->elements = $newElements + $this->elements;

        return $this;
    }


    /**
     * Get a random element
     *
     * @return  object
     */
    public function randomElement()
    {
        return $this->elements[$this->randomKey()];
    }


    /**
     * Get specified number of random elements
     *
     * @param   int $count
     * @return  TypedCollectionInterface
     */
    public function randomElements($count)
    {
        $keys = $this->randomKeys($count);

        return $this->pick($keys);
    }


    /**
     * Remove element by its value
     *
     * @param   object $element
     * @return  $this
     */
    public function removeElement($element)
    {
        $this->assertAllowedType($element);

        $identity = $this->getElementIdentity($element);

        unset($this->elements[$identity]);

        return $this;
    }


    /**
     * Remove elements by their value
     *
     * @param   object[] $elements
     * @return  $this
     */
    public function removeElements(array $elements)
    {
        $this->assertAllowedTypes($elements);

        $keys = [];
        foreach ($elements as $element) {
            $keys[] = $this->getElementIdentity($element);
        }

        $this->removeKeys($keys);

        return $this;
    }


    /**
     * Set/update element of given key
     *
     * Will check if key belongs to element.
     *
     * @param   string|int $key
     * @param   object     $element
     * @return  $this
     * @throws  KeyAndElementNotMatchException
     */
    public function set($key, $element)
    {
        $this->assertAllowedType($element);

        $identity = $this->getElementIdentity($element);
        if ($identity != $key) {
            throw new KeyAndElementNotMatchException(
                'Element identity did not same with key'
            );
        }

        $this->elements[$key] = $element;

        return $this;
    }


    /**
     * Remove element from beginning and return removed element
     *
     * @return  object
     */
    public function shift()
    {
        return array_shift($this->elements);
    }


    /**
     * Remove multiple elements from beginning and return removed element
     *
     * @param   int $count
     * @return  TypedCollectionInterface
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
            $keys = $this->getKeys();
            $keys = array_splice($keys, 0, $count);

            return $this->take($keys);
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
     * @return  TypedCollectionInterface
     */
    public function take(array $keys)
    {
        $taken = $this->pick($keys);

        $this->removeKeys($keys);

        return $taken;
    }
}
