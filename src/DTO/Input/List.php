<?php

declare(strict_types=1);

namespace BRCas\CA\DTO\Input;

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
