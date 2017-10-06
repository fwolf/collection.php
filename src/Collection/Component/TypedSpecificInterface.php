<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Exception\NotAllowedTypeException;
use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Shared method of typed collection, additional to normal collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface TypedSpecificInterface
{
    /**
     * Check given element is instance of allowed type or throw exception
     *
     * @param   object $element
     * @return  $this
     * @throws  NotAllowedTypeException
     */
    public function assertAllowedType($element);


    /**
     * Check elements are all instance of allowed type or throw exception
     *
     * @param   object[] $elements
     * @return  $this
     * @throws  NotAllowedTypeException
     */
    public function assertAllowedTypes(array $elements);


    /**
     * Compare two element
     *
     * Child class should overwrite this method to compare elements consider
     * their logic meaning. Need by sort and search methods.
     *
     * By default elements will be compared by their identity.
     *
     * Returns
     *
     *  - -1 when a < b
     *  -  0 when a = b
     *  -  1 when a > b
     *
     * If a < b, then a will sort before b in result.
     *
     * @param   object $element1 The 'a' in phpdoc
     * @param   object $element2 The 'b' in phpdoc
     * @return  int
     */
    public function compareElement($element1, $element2);


    /**
     * Create a new collection with same allowed type
     *
     * @param   object[] $elements
     * @return  TypedCollectionInterface
     */
    public function createCollection($elements = []);


    /**
     * Getter of allowed type/className
     *
     * @return  string
     */
    public function getAllowedType();


    /**
     * Get identity of element, will use as key in collection
     *
     * Can be overwritten by child class, to implement unique element identity
     * by actual element class logic.
     *
     * Will do type check at first.
     *
     * @param   object $element
     * @return  string|int
     */
    public function getElementIdentity($element);


    /**
     * Check given element is instance of allowed type
     *
     * @param   object $element
     * @return  bool
     */
    public function isAllowedType($element);


    /**
     * Setter of allowed type/className
     *
     * @param   string $className
     * @return  $this
     */
    public function setAllowedType($className);
}
