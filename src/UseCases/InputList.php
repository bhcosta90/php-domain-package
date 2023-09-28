<?php

declare(strict_types=1);

namespace BRCas\CA\UseCases;

class InputList
{
    public function __construct(
        public int $limit,
        public int $page,
        public array $filters = [],
    ) {
        //
    }
}
