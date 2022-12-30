<?php

namespace Costa\DomainPackage\ValueObject;

class Password
{
    public function __construct(public readonly ?string $password)
    {
        //
    }

    public function decrypt()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function login($password)
    {
        return password_verify($password, $this->decrypt());
    }

    public function __toString()
    {
        return (string) $this->decrypt();
    }
}
