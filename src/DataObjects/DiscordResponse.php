<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

class DiscordResponse implements \JsonSerializable
{
    public function __construct(
        private string $applicationId,
        private string $interactionId,
        private int $type,
        private Message|AutoCompleteCollection|null $data = null,
        private ?\Closure $callback = null
    ) {
    }
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function getInteractionId(): string
    {
        return $this->interactionId;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getData(): Message|AutoCompleteCollection|null
    {
        return $this->data;
    }

    public function getCallback(): ?\Closure
    {
        return $this->callback;
    }

    public function jsonSerialize(): array
    {
        if ($this->data !== null) {
            return [
                'type' => $this->type,
                'data' => $this->data->jsonSerialize(),
            ];
        }

        return [
            'type' => $this->type,
        ];
    }
}
