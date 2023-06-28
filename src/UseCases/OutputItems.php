<?php

declare(strict_types=1);

namespace BRCas\CA\UseCases;

class OutputItems
{
    public function __construct(
        public array $items,
        public int $total,
    ) {
        //
    }
}
