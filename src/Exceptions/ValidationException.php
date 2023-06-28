<?php

declare(strict_types=1);

namespace BRCas\CA\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public static array $error = [];

    public function __construct(string $message = "", int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function withMessage(array $errors)
    {
        self::$error = $errors;
        return new self("ValidationException");
    }

    public function getError(): array
    {
        return self::$error;
    }
}
