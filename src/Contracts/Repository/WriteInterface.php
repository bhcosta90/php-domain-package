<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Repository;

use Costa\Entity\Data;

interface WriteInterface
{
    public function create(Data $entity): bool;

    public function update(Data $entity): bool;

    public function delete(Data $entity): bool;
}