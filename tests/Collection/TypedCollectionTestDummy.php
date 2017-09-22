<?php

namespace FwolfTest\Common\Collection;

use Fwolf\Common\Collection\TypedCollection;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedCollectionTestDummy extends TypedCollection
{
    /**
     * {@inheritDoc}
     */
    protected $allowedType = 'stdClass';
}
