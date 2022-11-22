<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash;

use Discord\Interaction;
use Discord\InteractionResponseType;
use Discord\InteractionType;
use PathfinderMediaGroup\DiscordSlash\Commands\AutoCompleteInterface;
use PathfinderMediaGroup\DiscordSlash\Commands\InteractionInterface;
use PathfinderMediaGroup\DiscordSlash\Commands\SlashCommandInterface;
use PathfinderMediaGroup\DiscordSlash\Exceptions\InvalidInteractionTypeException;
use PathfinderMediaGroup\DiscordSlash\Exceptions\UnknownApplicationException;
use PathfinderMediaGroup\DiscordSlash\Exceptions\UnknownCommandException;
use PathfinderMediaGroup\DiscordSlash\Factories\Factory;

class Handler
{
    private static array $commands = [];
    private static array $applications = [];

    public static function registerCommand(string $applicationId, string $command, string $commandClass): void
    {
        self::$commands[$applicationId][$command] = $commandClass;
    }

    public static function registerCommands(string $applicationId, array $commands): void
    {
        self::$commands[$applicationId] = array_merge(self::$commands[$applicationId] ?? [], $commands);
    }

    public static function registerApplication(string $applicationId, string $verificationKey): void
    {
        self::$applications[$applicationId] = $verificationKey;
    }

    public static function handle(array $requestData): array
    {
        if ($requestData['type'] === InteractionType::PING) {
            return ['type' => InteractionResponseType::PONG];
        }
        $interaction = Factory::slashCommandInteraction($requestData);
        if (! isset(self::$commands[$interaction->getApplicationId()][$interaction->getName()])) {
            throw new UnknownCommandException(
                'A discord command was called that has not been configured',
                1669135864,
                applicationId: $interaction->getApplicationId(),
                command: $interaction->getName()
            );
        }
        $class = self::$commands[$interaction->getApplicationId()][$interaction->getName()];
        $class = new $class();
        if ($requestData['type'] === InteractionType::APPLICATION_COMMAND && $class instanceof SlashCommandInterface) {
            return [
                'type' => InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE,
                'data' => (new $class())->slashCommand($interaction),
            ];
        }
        if ($requestData['type'] === InteractionType::MESSAGE_COMPONENT && $class instanceof InteractionInterface) {
            return [
                'type' => InteractionResponseType::UPDATE_MESSAGE,
                'data' => (new $class())->interaction($interaction),
            ];
        }
        if ($requestData['type'] === InteractionType::APPLICATION_COMMAND_AUTOCOMPLETE && $class instanceof AutoCompleteInterface) {
            return [
                'type' => InteractionResponseType::APPLICATION_COMMAND_AUTOCOMPLETE_RESULT,
                'data' => [
                    'choices' =>  (new $class())->autoComplete($interaction)->limit(),
                ],
            ];
        }

        throw new InvalidInteractionTypeException(
            'Discord interaction was not resolvable to a class',
            1669136019,
            applicationId: $interaction->getApplicationId(),
            type: $requestData['type'],
            command: $interaction->getName()
        );
    }

    public static function validateRequest(string $requestBody, string $applicationId, string $signature, string|int $timestamp): bool
    {
        if (! isset(self::$applications[$applicationId])) {
            throw new UnknownApplicationException(
                'Trying to validate an unknown Discord application',
                1669195291,
                applicationId: $applicationId
            );
        }

        return Interaction::verifyKey(
            $requestBody,
            $signature,
            $timestamp,
            self::$applications[$applicationId]
        );
    }
}
