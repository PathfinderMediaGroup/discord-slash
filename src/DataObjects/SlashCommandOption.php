<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class SlashCommandOption
{
    private string $name;
    private string|int|null $value;
    private int $type;
    private bool $focussed = false;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): string|int|null
    {
        return $this->value;
    }

    public function setValue(string|int|null $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFocussed(): bool
    {
        return $this->focussed;
    }

    public function setFocussed(bool $focussed): self
    {
        $this->focussed = $focussed;

        return $this;
    }
}
