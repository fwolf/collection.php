<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\Exception\NotAllowedTypeException;

/**
 * Implement of {@link TypedSpecificInterface}
 *
 * @property    string $allowedType
 * @property    array  $elements
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
trait TypedSpecificTrait
{
    /**
     * Check given element is instance of allowed type or throw exception
     *
     * @param   object $element
     * @return  $this
     * @throws  NotAllowedTypeException
     */
    public function assertAllowedType($element)
    {
        if (!$this->isAllowedType($element)) {
            $class = $this->getAllowedType();
            throw new NotAllowedTypeException(
                "Only $class instance allowed"
            );
        }

        return $this;
    }


    /**
     * Check elements are all instance of allowed type or throw exception
     *
     * @param   object[] $elements
     * @return  $this
     * @throws  NotAllowedTypeException
     */
    public function assertAllowedTypes(array $elements)
    {
        $class = $this->getAllowedType();

        foreach ($elements as $element) {
            if (!$this->isAllowedType($element)) {
                throw new NotAllowedTypeException(
                    "Only $class instance allowed"
                );
            }
        }

        return $this;
    }


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
    public function compareElement($element1, $element2)
    {
        // Element compare relies on class logic, this simple implement will
        // compare by identity.
        $identity1 = $this->getElementIdentity($element1);
        $identity2 = $this->getElementIdentity($element2);

        if ($identity1 == $identity2) {
            return 0;
        } elseif ($identity1 < $identity2) {
            return -1;
        } else {
            return 1;
        }
    }


    /**
     * Getter of allowed type/className
     *
     * @return  string
     */
    public function getAllowedType()
    {
        return $this->allowedType;
    }


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
    public function getElementIdentity($element)
    {
        $this->assertAllowedType($element);


        // As result of spl_object_hash() maybe re-used or duplicate, we need
        // a real unique identity. Here is a simple one, implement with class
        // logic is better.

        // Should not duplicate with exists element property
        $propertyName = '_identityInTypedCollection';

        if (property_exists($element, $propertyName)) {
            return $element->$propertyName;
        } else {
            list($usec, $sec) = explode(" ", microtime());
            $usec = trim($usec, '0');
            $identity = $sec . $usec;
            $element->$propertyName = $identity;

            return $identity;
        }
    }


    /**
     * Check given element is instance of allowed type
     *
     * @param   object $element
     * @return  bool
     */
    public function isAllowedType($element)
    {
        return $this->getAllowedType() == get_class($element);
    }
}
