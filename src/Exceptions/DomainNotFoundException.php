<?php

declare(strict_types=1);

namespace BRCas\CA\Exceptions;

use Exception;

class DomainNotFoundException extends Exception
{
    public function __construct(string $domain, string $id)
    {
        parent::__construct("Domain {$domain} with id {$id} not found", 404);
    }
}
