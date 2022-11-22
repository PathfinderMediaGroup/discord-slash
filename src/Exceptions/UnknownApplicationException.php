<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Exceptions;

class UnknownApplicationException extends \Exception
{
    public function __construct(string $message, int $code, ?\Throwable $previous = null, protected string $applicationId)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getApplicationId(): string
    {
        return $this->applicationId;
    }
}
