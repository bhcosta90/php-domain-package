<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Event;

use Costa\Entity\Contracts\EventInterface;

interface EventManagerInterface
{
    /**
     * @param EventInterface[] $event
     * @return void
     */
    public function dispatch(array $event): void;
}
