<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class SlashCommand implements DiscordComponentInterface
{
    private string $name;
    private int $type = 1;
    private string $description;
    private array $options = [];
    private bool $availableInDm = true;

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'options' => $this->options,
            'dm_permission' => $this->availableInDm,
        ];
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

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function isAvailableInDm(): bool
    {
        return $this->availableInDm;
    }

    public function setAvailableInDm(bool $availableInDm): self
    {
        $this->availableInDm = $availableInDm;

        return $this;
    }

    public function addStringOption(string $name, string $description, bool $required = true, bool $autoComplete = false): self
    {
        $this->options[] = [
            'name' => $name,
            'description' => $description,
            'required' => $required,
            'type' => 3,
            'autocomplete' => $autoComplete,
        ];

        return $this;
    }

    public function addChoiceOption(string $name, string $description, array $choices, bool $required = true): self
    {
        $this->options[] = [
            'name' => $name,
            'description' => $description,
            'required' => $required,
            'type' => 3,
            'choices' => $choices,
        ];

        return $this;
    }

    public function addNumberOption(string $name, string $description, int $min, int $max, bool $required = true): self
    {
        $this->options[] = [
            'name' => $name,
            'description' => $description,
            'required' => $required,
            'type' => 4,
            'min_value' => $min,
            'max_value' => $max,
        ];

        return $this;
    }
}
