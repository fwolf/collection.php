<?php

namespace Fwolf\Common\Collection;

/**
 * Implement for {@link TypedCollectionInterface}
 *
 * Usage: Inherit as a child class, and assign instance class name to
 * {@link $allowedType}. Method {@link compareElement()} and
 * {@link getElementIdentity()} may need overwritten by nature logic of
 * allowed type.
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedCollection implements TypedCollectionInterface
{
    use TypedCollectionTrait;


    /**
     * Allowed elements type/className of this collection
     *
     * @var string
     */
    protected $allowedType = '';

    /**
     * Real elements in collection
     *
     * @var array
     */
    protected $elements = [];


    /**
     * Constructor
     *
     * @param   array $elements
     */
    public function __construct(array $elements = [])
    {
        $this->assertAllowedTypes($elements);

        // In case elements do not have proper key
        foreach ($elements as $element) {
            $identity = $this->getElementIdentity($element);
            $this->elements[$identity] = $element;
        }
    }
}
