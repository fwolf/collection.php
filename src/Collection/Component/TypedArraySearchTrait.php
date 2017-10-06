<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Implement of {@link TypedArraySearchInterface}
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
trait TypedArraySearchTrait
{
    use ArraySearchTrait;


    /**
     * Check if collection have given element
     *
     * @param   object $element
     * @return  bool
     */
    public function hasElement($element)
    {
        return false !== $this->indexOf($element);
    }


    /**
     * {@inheritdoc}
     *
     * As the key should be element identity, so this will check key/identity
     * exists and the inner element and given are same.
     *
     * @param   object $element
     * @return  string|int|bool Return false when not found.
     */
    public function indexOf($element)
    {
        $this->assertAllowedType($element);

        $identity = $this->getElementIdentity($element);

        if (!array_key_exists($identity, $this->elements)) {
            return false;
        }
        $innerElement = $this->elements[$identity];

        if (0 === $this->compareElement($innerElement, $element)) {
            return $identity;
        } else {
            return false;
        }
    }


    /**
     * Get collection of elements satisfy given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  TypedCollectionInterface
     */
    public function matching(callable $predicate)
    {
        $matched = $this->createCollection();

        foreach ($this->elements as $key => $element) {
            if (true == $predicate($element)) {
                $matched->set($key, $element);
            }
        }

        return $matched;
    }
}
