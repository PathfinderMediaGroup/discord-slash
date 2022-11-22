<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Commands;

use PathfinderMediaGroup\DiscordSlash\DataObjects\AutoCompleteCollection;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandInteraction;

interface AutoCompleteInterface
{
    public function autoComplete(SlashCommandInteraction $interaction): AutoCompleteCollection;
}
