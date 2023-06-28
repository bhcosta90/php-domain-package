<?php

declare(strict_types=1);

namespace BRCas\CA\VO\Password;

use BRCas\CA\Exceptions\ValidationException;
use BRCas\CA\Validation\RakitValidation;

class Validate
{
    public static function execute(Password $vo)
    {
        $errors = RakitValidation::validate([
            "password" => $vo->hash,
        ], [
            "password" => ["required", "min:8"],
        ]);

        if ($errors) {
            throw ValidationException::withMessage($errors);
        }
    }
}
