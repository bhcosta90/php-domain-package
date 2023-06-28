<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Event;

interface EventManagerInterface
{
    public function dispatch(EventInterface $event);
}
