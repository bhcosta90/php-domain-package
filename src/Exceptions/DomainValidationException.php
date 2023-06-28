<?php

declare(strict_types=1);

namespace BRCas\CA\Exceptions;

use Exception;

class DomainValidationException extends Exception
{
    public static array $error = [];

    public function __construct(string $message = "", int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function withMessage(string $key, string $message)
    {
        self::$error = [
            'key' => $key,
            'message' => $message,
        ];

        return new self("DomainValidationException: {$key} - {$message}");
    }

    public function getError(): array
    {
        return self::$error;
    }
}
