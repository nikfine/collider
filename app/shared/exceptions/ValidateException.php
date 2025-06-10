<?php

namespace shared\exceptions;

use Throwable;

class ValidateException extends \Exception
{
    /**
     * @param array<mixed> $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(private array $errors, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<mixed>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}