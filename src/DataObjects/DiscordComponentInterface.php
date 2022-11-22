<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

interface DiscordComponentInterface
{
    public function jsonSerialize(): array;
}
