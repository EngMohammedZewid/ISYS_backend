<?php

namespace App\Exceptions;

final class ExampleException extends InternalException
{
    public static function throw(): static
    {
        return self::new(ExceptionCode::Example);
    }
}
