<?php

declare(strict_types=1);

namespace BRCas\CA\DTO\Output;

class Delete
{
    public function __construct(
        public bool $success,
    ) {
        //
    }
}
