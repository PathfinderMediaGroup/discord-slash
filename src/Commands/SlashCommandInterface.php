<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Commands;

use PathfinderMediaGroup\DiscordSlash\DataObjects\Message;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommand;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandInteraction;

interface SlashCommandInterface
{
    public function slashCommand(SlashCommandInteraction $interaction): Message;

    public static function description(): string;

    public static function configuration(): SlashCommand;
}
