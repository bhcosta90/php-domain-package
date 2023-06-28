<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Transaction;

interface DatabaseTransactionInterface
{
    public function commit(): void;

    public function rollback(): void;
}
