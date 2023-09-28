<?php

declare(strict_types=1);

namespace BRCas\CA\UseCases;

use Costa\Entity\Data;

class OutputItems
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
