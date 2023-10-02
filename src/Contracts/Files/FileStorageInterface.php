<?php

declare(strict_types=1);

namespace BRCas\CA\Contracts\Files;

interface FileStorageInterface
{
    /**
     * @param string $path
     * @param array $file
     * @return string
     */
    public function store(string $path, array $file): string;

    /**
     * @param string $path
     * @return bool
     */
    public function delete(string $path): bool;
}
