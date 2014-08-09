<?php

namespace DCP\Mapper\Transformers;

use DCP\Mapper\TransformerInterface;

class CallbackTransformer implements TransformerInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function transform($value)
    {
        return call_user_func_array($this->callback, [$value]);
    }
}
