<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class Button implements \JsonSerializable, DiscordComponentInterface
{
    public const TYPE = 2;
    public const STYLE_PURPLE = 1;
    public const STYLE_GREY = 2;
    public const STYLE_GREEN = 3;
    public const STYLE_RED = 4;
    public const STYLE_LINK = 5;

    private int $style;
    private string $label;
    private ?string $customId = null;
    private ?string $url = null;
    private bool $disabled = false;
    private ?array $emoji = null;

    public function jsonSerialize(): array
    {
        return [
            'type' => self::TYPE,
            'style' => $this->style,
            'label' => $this->label,
            'url' => $this->url,
            'custom_id' => $this->customId,
            'disabled' => $this->disabled,
            'emoji' => $this->emoji,
        ];
    }

    public function getStyle(): int
    {
        return $this->style;
    }

    public function setStyle(int $style): self
    {
        $this->style = $style;

        return $this;
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

    public function getCustomId(): ?string
    {
        return $this->customId;
    }

    public function setCustomId(?string $customId): self
    {
        $this->customId = $customId;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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

    public function setEmoji(string $name, string $id, bool $animated = false): self
    {
        $this->emoji = [
            'id' => $id,
            'name' => $name,
            'animated' => $animated,
        ];

        return $this;
    }

    public function getEmoji(): ?array
    {
        return $this->emoji;
    }

    public function removeEmoji(): self
    {
        $this->emoji = null;

        return $this;
    }
}
