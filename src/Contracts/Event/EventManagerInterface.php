<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Event;

use Costa\Entity\Contracts\EventInterface;

interface EventManagerInterface
{
    public function dispatch(EventInterface $event);
}
