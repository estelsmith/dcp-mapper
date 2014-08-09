<?php

namespace tests\Stubs;

use DCP\Mapper\Collection;

/**
 * @codeCoverageIgnore
 */
class CollectionStub extends Collection
{
    public function __construct($data = [])
    {
        $this->data = $data;
    }
}
