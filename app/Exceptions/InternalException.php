<?php

namespace App\Exceptions;

use Exception;

abstract class InternalException extends Exception
{
    protected string $description;

    protected ExceptionCode $internalCode;

    final public function __construct(
        string $message,
        int $statusCode,
    ) {
        parent::__construct($message, $statusCode);
    }

    public static function new(
        ExceptionCode $code,
        ?string $message = null,
        ?string $description = null,
        ?int $statusCode = null,
    ): static {
        $exception = new static(
            $message ?? $code->getMessage(),
            $statusCode ?? $code->getStatusCode(),
        );

        $exception->internalCode = $code;
        $exception->description = $description ?? $code->getDescription();

        return $exception;
    }

    public function getInternalCode(): ExceptionCode
    {
        return $this->internalCode;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    abstract public static function throw(): static;
}
