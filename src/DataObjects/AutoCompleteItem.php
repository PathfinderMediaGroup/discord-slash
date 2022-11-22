<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class AutoCompleteItem implements \JsonSerializable
{
    public function __construct(private string|int $value, private string $name)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'name' => $this->name,
        ];
    }

    public function getValue(): int|string
    {
        return $this->value;
    }

    public function setValue(int|string $value): self
    {
        $this->value = $value;

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
}
