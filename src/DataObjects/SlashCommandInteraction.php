<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class SlashCommandInteraction
{
    private string $applicationId;
    private string $channelId;
    private ?string $guildId;
    private string $userId;
    private string $name;
    private array $options = [];
    private ?string $userPermissions;
    private bool $isDm = false;

    public function addOption(SlashCommandOption $option): self
    {
        $this->options[] = $option;

        return $this;
    }

    public function getOption(string $name): ?SlashCommandOption
    {
        foreach ($this->options as $option) {
            if ($option->getName() === $name) {
                return $option;
            }
        }

        return null;
    }

    public function getFocussedOption(): ?SlashCommandOption
    {
        foreach ($this->options as $option) {
            if ($option->getFocussed()) {
                return $option;
            }
        }

        return null;
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

    public function getGuildId(): ?string
    {
        return $this->guildId;
    }

    public function setGuildId(?string $guildId): self
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUserPermissions(): ?string
    {
        return $this->userPermissions;
    }

    public function setUserPermissions(?string $userPermissions): self
    {
        $this->userPermissions = $userPermissions;

        return $this;
    }

    public function userIsAdmin(): bool
    {
        return '8' === gmp_strval(gmp_and($this->getUserPermissions(), 0x8));
    }

    public function setDm(bool $isDm): self
    {
        $this->isDm = $isDm;

        return $this;
    }

    public function isDm(): bool
    {
        return $this->isDm;
    }
}
