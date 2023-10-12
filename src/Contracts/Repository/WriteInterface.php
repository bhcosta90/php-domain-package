<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Repository;

use Costa\Entity\Interfaces\DataInterface;

interface WriteInterface
{
    public function create(DataInterface $entity): bool;

    public function update(DataInterface $entity): bool;

    public function delete(DataInterface $entity): bool;
}