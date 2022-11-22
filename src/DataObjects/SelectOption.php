<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class SelectOption implements \JsonSerializable
{
    private string $label;
    private string $value;
    private ?string $description = null;
    private ?bool $default = null;

    public function jsonSerialize(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'description' => $this->description,
            'default' => $this->default,
        ];
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDefault(): ?bool
    {
        return $this->default;
    }

    public function setDefault(?bool $default): self
    {
        $this->default = $default;

        return $this;
    }
}
