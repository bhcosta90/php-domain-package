<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Entity;

interface EntityInterface
{
    /** @return array */
    public function toArray();

    public function update(array $data = []);
}
