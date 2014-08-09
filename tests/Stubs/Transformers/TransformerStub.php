<?php

namespace tests\Stubs\Transformers;

use DCP\Mapper\TransformerInterface;

/**
 * @codeCoverageIgnore
 */
class TransformerStub implements TransformerInterface
{
    private $result;

    public function __construct($result = null)
    {
        $this->result = $result;
    }

    public function transform($value)
    {
        return $this->result;
    }
}
