<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Entity;

interface FactoryInterface
{
    public function make(array $data): EntityInterface;
}
