<?php

declare(strict_types=1);

namespace BRCas\CA\DTO\Output;

class DeleteOutput
{
    public function __construct(
        public bool $success,
    )
    {
        //
    }
}
