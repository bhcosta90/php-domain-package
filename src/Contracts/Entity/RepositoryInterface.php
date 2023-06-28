<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Entity;

use BRCas\CA\Abstracts\EntityAbstract;
use BRCas\CA\Contracts\Items;

interface RepositoryInterface
{
    public function create(EntityAbstract $entity): bool;
    public function find(string $id, array $with = []): EntityAbstract;
    public function update(EntityAbstract $entity): bool;
    public function delete(EntityAbstract $entity): bool;
    public function pluck(): array;
    public function items(array $filter = [], array $with = []): Items\ItemInterface;
    public function paginate(array $filter = [], array $with = []): Items\PaginationInterface;
}
