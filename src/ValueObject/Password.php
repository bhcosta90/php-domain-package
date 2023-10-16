<?php

declare(strict_types=1);

namespace BRCas\CA\ValueObject;

use Costa\Entity\Interfaces\ValueObjectInterface;
use InvalidArgumentException;

class Password implements ValueObjectInterface
{
    public string $hash;

    public static function make(?string $password = null): self
    {
        if (empty($password)) {
            throw new InvalidArgumentException('password do not passed');
        }

        return new self($password);
    }

    public function login($password): bool
    {
        return password_verify($password, $this->hash);
    }

    public function __toString(): string
    {
        return (string)$this->hash;
    }

    public function __construct(mixed $value)
    {
        $this->hash = $value;

        if (password_get_info($value)['algoName'] == 'unknown') {
            $this->hash = password_hash($value, PASSWORD_DEFAULT);
        }
    }
}
