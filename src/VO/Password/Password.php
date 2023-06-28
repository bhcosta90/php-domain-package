<?php

declare(strict_types=1);

namespace BRCas\CA\VO\Password;

class Password
{
    public string $hash;

    public function __construct(string $password)
    {
        $this->hash = $password;
        Validate::execute($this);

        if (password_get_info($password)['algoName'] == 'unknown') {
            $this->hash = password_hash($password, PASSWORD_DEFAULT);
        }
    }

    public function login($password)
    {
        return password_verify($password, $this->password);
    }

    public function __toString()
    {
        return (string) $this->hash;
    }
}
