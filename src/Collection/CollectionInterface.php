<?php

namespace Fwolf\Common\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Collection is better way to operate array alike data
 *
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
interface CollectionInterface extends
    ArrayAccess,
    Countable,
    IteratorAggregate
{
}
