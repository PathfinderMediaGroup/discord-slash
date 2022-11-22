<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class ActionRow implements \JsonSerializable
{
    public const TYPE = 1;
    private array $components = [];

    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE,
            'components' => $this->components,
        ];
    }

    /**
     * @return DiscordComponentInterface[]
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function addComponent(DiscordComponentInterface $component): self
    {
        $this->components[] = $component;

        return $this;
    }

    public function setComponents(array $components): self
    {
        $this->components = array_filter($components, static function ($e) {
            return $e instanceof DiscordComponentInterface;
        });

        return $this;
    }
}
