<?php

declare(strict_types=1);

namespace BRCas\CA\ValueObject;

use Costa\Entity\Contracts\ValueObjectInterface;
use InvalidArgumentException;

class Password implements ValueObjectInterface
{
    public string $hash;

    public function __construct(string $password)
    {
        $this->hash = $password;

        if (password_get_info($password)['algoName'] == 'unknown') {
            $this->hash = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public static function make(?string $password = null): self
    {
        if (empty($password)) {
            throw new InvalidArgumentException('password do not passed');
        }

        return new self($password);
    }

    public function login($password): bool
    {
        return password_verify($password, $this->password);
    }

    public function __toString(): string
    {
        return (string)$this->hash;
    }
}
