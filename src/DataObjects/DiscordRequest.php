<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class DiscordRequest
{
    private string $channelId;
    private string $guildId;
    private string $userId;
    private string $args;

    public function __construct(array $requestData)
    {
        $this->channelId = $requestData['channelId'];
        $this->guildId = $requestData['guildId'];
        $this->userId = $requestData['userId'];
        $this->args = $requestData['args'] ?? '';
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getGuildId(): string
    {
        return $this->guildId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getArgs(): string
    {
        return $this->args;
    }
}
