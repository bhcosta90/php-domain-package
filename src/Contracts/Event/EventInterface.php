<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Event;

interface EventInterface
{
    public function getEventName(): string;

    public function getPayload(): array;
}
