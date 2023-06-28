<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Items;

interface ItemInterface
{
    public function items(): array;

    public function total(): int;
}
