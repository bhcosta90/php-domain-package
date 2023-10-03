<?php

declare(strict_types=1);

namespace BRCas\CA\DTO\Output;

use Costa\Entity\Data;

class ItemsOutput
{
    /**
     * @param Data[] $items
     * @param int $total
     */
    public function __construct(
        public array $items,
        public int $total,
    ) {
        //
    }
}
