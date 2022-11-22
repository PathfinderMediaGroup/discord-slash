<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class SelectMenu implements \JsonSerializable, DiscordComponentInterface
{
    public const TYPE = 3;
    private string $customId;
    private array $options = [];
    private ?string $placeHolder = null;
    private ?int $minValues = null;
    private ?int $maxValues = null;
    private bool $disabled = false;

    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE,
            'custom_id' => $this->customId,
            'options' => $this->options,
            'placeholder' => $this->placeHolder,
            'min_values' => $this->minValues,
            'max_values' => $this->maxValues,
            'disabled' => $this->disabled,
        ];
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

    /**
     * @return SelectOption[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(array $options): self
    {
        $this->options = array_filter($options, static function ($e) {
            return $e instanceof SelectOption;
        });

        return $this;
    }

    public function addOption(SelectOption $option): self
    {
        $this->options[] = $option;

        return $this;
    }

    public function getPlaceHolder(): ?string
    {
        return $this->placeHolder;
    }

    public function setPlaceHolder(?string $placeHolder): self
    {
        $this->placeHolder = $placeHolder;

        return $this;
    }

    public function getMinValues(): ?int
    {
        return $this->minValues;
    }

    public function setMinValues(?int $minValues): self
    {
        $this->minValues = $minValues;

        return $this;
    }

    public function getMaxValues(): ?int
    {
        return $this->maxValues;
    }

    public function setMaxValues(?int $maxValues): self
    {
        $this->maxValues = $maxValues;

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }
}
