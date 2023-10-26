<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Transaction;

use Closure;

interface DatabaseTransactionInterface
{
    public function transaction(Closure $closure);
}
