<?php

namespace FwolfTest\Common\Collection\Component;

use stdClass;

/**
 * @copyright   Copyright 2017 Fwolf
 * @license     https://opensource.org/licenses/MIT MIT
 */
class TypedCollectionTestDummy extends stdClass
{
    /**
     * @var string|int
     */
    protected $identity = null;


    /**
     * @param   string|int $identity
     */
    public function __construct($identity = null)
    {
        $this->identity = $identity;
    }


    /**
     * @return  int|string
     */
    public function getIdentity()
    {
        return $this->identity;
    }


    /**
     * @param   int|string $identity
     * @return  $this
     */
    public function setIdentity($identity)
    {
        $this->identity = $identity;

        return $this;
    }
}
