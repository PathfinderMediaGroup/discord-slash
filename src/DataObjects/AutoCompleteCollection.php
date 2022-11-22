<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

final class AutoCompleteCollection implements \JsonSerializable
{
    private array $items = [];

    public function jsonSerialize(): array
    {
        return $this->items;
    }

    public function add(AutoCompleteItem $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    public function limit(int $limit = 25): self
    {
        $this->items = array_slice($this->items, 0, $limit);

        return $this;
    }
}
