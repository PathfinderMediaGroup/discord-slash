<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Commands;

use PathfinderMediaGroup\DiscordSlash\DataObjects\Interaction;
use PathfinderMediaGroup\DiscordSlash\DataObjects\Message;

interface InteractionInterface
{
    public function interaction(Interaction $interaction): Message;
}
