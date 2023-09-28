<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Repository;

use BRCas\CA\Contracts\Items\ItemInterface;
use BRCas\CA\Contracts\Items\PaginationInterface;
use Costa\Entity\Data;

interface ReadInterface
{
    public function find(string $id, array $with = []): Data;

    public function items(array $filter = [], array $with = []): ItemInterface;

    public function paginate(array $filter = [], array $with = []): PaginationInterface;

    public function pluck(): array;
}