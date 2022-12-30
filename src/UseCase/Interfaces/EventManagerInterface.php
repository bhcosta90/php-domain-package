<?php

namespace Costa\DomainPackage\UseCase\Interfaces;

use Costa\DomainPackage\Domain\Event\EventInterface;

interface EventManagerInterface
{
    /** @var EventInterface $events[] */
    public function dispatch(array $events): void;
}
