<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Event;

use Costa\Entity\Contracts\EventInterface;

interface EventManagerInterface
{
    /**
     * @param EventInterface[] $events
     * @return void
     */
    public function dispatch(array $events): void;
}
