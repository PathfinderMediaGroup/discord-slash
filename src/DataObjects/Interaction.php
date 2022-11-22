<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class Interaction implements \JsonSerializable
{
    private string $applicationId;
    private string $channelId;
    private int $componentType;
    private string $customId;
    private array $values = [];
    private string $guildId;
    private string $userId;
    private Message $message;

    public function jsonSerialize(): array
    {
        return [
            'application_id' => $this->applicationId,
            'channel_id' => $this->channelId,
            'data' => [
                'component_type' => $this->componentType,
                'custom_id' => $this->customId,
                'values' => $this->values,
            ],
            'guild_id' => $this->guildId,
            'user_id' => $this->userId,
            'message' => $this->message,
        ];
    }

    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function setApplicationId(string $applicationId): self
    {
        $this->applicationId = $applicationId;

        return $this;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function getComponentType(): int
    {
        return $this->componentType;
    }

    public function setComponentType(int $componentType): self
    {
        $this->componentType = $componentType;

        return $this;
    }

    public function getCustomId(): string
    {
        return $this->customId;
    }

    public function setCustomId(string $customId): self
    {
        $this->customId = $customId;

        return $this;
    }

    public function getGuildId(): string
    {
        return $this->guildId;
    }

    public function setGuildId(string $guildId): self
    {
        $this->guildId = $guildId;

        return $this;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function hasValue(string $value): bool
    {
        return in_array($value, $this->values, true);
    }

    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }
}
