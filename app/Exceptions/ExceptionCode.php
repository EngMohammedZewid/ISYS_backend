<?php

namespace App\Exceptions;

enum ExceptionCode: int
{
    case RouteNotFound = 400001;
    case ModelNotFound = 400002;
    case Example = 400003;
    case OTPVerficationException = 500001;
    case OTPVerficationRecentlyUpdateException = 500002;

    public function getStatusCode(): int
    {
        $value = $this->value;

        return match (true) {
            $value > 600000 => 500, /** @phpstan-ignore-line */ //server errors
            $value > 500000 => 422,
            $value > 400000 => 404, /** @phpstan-ignore-line */ //Not found
            $value > 300000 => 403, /** @phpstan-ignore-line */ //Forbidden
            $value > 200000 => 401, /** @phpstan-ignore-line */ //Unauthorized
            $value > 100000 => 400, /** @phpstan-ignore-line */ //Bad request
            default => 500, /** @phpstan-ignore-line */
        };
    }

    public function getMessage(): string
    {
        $key = "exceptions.{$this->value}.message";
        $translation = __($key);

        if ($key === $translation) {
            return 'Something went wrong';
        }

        return $translation;
    }

    public function getDescription(): string
    {
        $key = "exceptions.{$this->value}.description";
        $translation = __($key);
        if ($key === $translation) {
            return 'No additional description provided';
        }

        return $translation;
    }
}
