<?php

namespace DCP\Mapper\Rules;

use DCP\Mapper\RuleInterface;

class CallbackRule implements RuleInterface
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function execute()
    {
        return (bool)call_user_func($this->callback);
    }
}
