<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\UseCase;

interface RegistryRepositoryInterface
{
    public function get(string $name);
}
