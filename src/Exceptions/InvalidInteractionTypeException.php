<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Exceptions;

class InvalidInteractionTypeException extends \Exception
{
    public function __construct(string $message, int $code, ?\Throwable $previous = null, protected string $applicationId, protected int $type, protected string $command)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getCommand(): string
    {
        return $this->command;
    }
}
