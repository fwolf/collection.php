<?php

namespace Fwolf\Common\Collection;

use ArrayAccess;
use Countable;
use Fwolf\Common\Collection\Component\ArrayAbleInterface;
use Fwolf\Common\Collection\Component\ArrayAccessorInterface;
use Iterator;

/**
 * Collection is better way to operate array alike data
 *
 * Collection focus on group and operate on values, not 'key', although inner
 * property $element is array with auto number key in default, and some method
 * use key as parameter, the key of element may change in may ways, so do not
 * rely on them. User may use assoc key or mix assoc key with auto increment key
 * too.
 *
 * Some sort or search method may need compare elements, use them only when you
 * know what type the elements are and if they are comparable.
 *
 * Suggestion: Collection with mixed type elements is terrible, use carefully.
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface CollectionInterface extends
    ArrayAbleInterface,
    ArrayAccess,
    ArrayAccessorInterface,
    Countable,
    Iterator
{
}
