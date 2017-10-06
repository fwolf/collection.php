<?php

namespace Fwolf\Common\Collection\Component;

use Fwolf\Common\Collection\TypedCollectionInterface;

/**
 * Search relate methods for collection
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface TypedArraySearchInterface extends ArraySearchInterface
{
    /**
     * Check if collection have given element
     *
     * @param   object $element
     * @return  bool
     */
    public function hasElement($element);


    /**
     * {@inheritdoc}
     *
     * As the key should be element identity, so this will check key/identity
     * exists and the inner element and given are same.
     *
     * @param   object $element
     * @return  string|int|bool Return false when not found.
     */
    public function indexOf($element);


    /**
     * Get collection of elements satisfy given predicate
     *
     * @param   callable $predicate Take element as first parameter
     * @return  TypedCollectionInterface
     */
    public function matching(callable $predicate);
}
