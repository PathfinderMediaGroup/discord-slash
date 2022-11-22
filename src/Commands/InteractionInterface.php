<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Commands;

use PathfinderMediaGroup\DiscordSlash\DataObjects\Message;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandInteraction;

interface InteractionInterface
{
    public function interaction(SlashCommandInteraction $interaction): Message;
}
