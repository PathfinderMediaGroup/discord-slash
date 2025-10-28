<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash;

use Discord\Interaction;
use Discord\InteractionResponseType;
use Discord\InteractionType;
use PathfinderMediaGroup\DiscordSlash\Commands\AutoCompleteInterface;
use PathfinderMediaGroup\DiscordSlash\Commands\InteractionInterface;
use PathfinderMediaGroup\DiscordSlash\Commands\SlashCommandInterface;
use PathfinderMediaGroup\DiscordSlash\DataObjects\DeferredDiscordResponse;
use PathfinderMediaGroup\DiscordSlash\DataObjects\DiscordResponse;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandInteraction;
use PathfinderMediaGroup\DiscordSlash\Exceptions\InvalidInteractionTypeException;
use PathfinderMediaGroup\DiscordSlash\Exceptions\UnknownApplicationException;
use PathfinderMediaGroup\DiscordSlash\Exceptions\UnknownCommandException;
use PathfinderMediaGroup\DiscordSlash\Factories\Factory;

class Handler
{
    private static array $commands = [];
    private static array $interactions = [];
    private static array $applications = [];

    public static function registerCommand(string $applicationId, string $command, string $commandClass): void
    {
        self::$commands[$applicationId][$command] = $commandClass;
    }

    public static function registerCommands(string $applicationId, array $commands): void
    {
        self::$commands[$applicationId] = array_merge(self::$commands[$applicationId] ?? [], $commands);
    }

    public static function registerInteraction(string $applicationId, string $interactionId, string $interactionClass): void
    {
        self::$interactions[$applicationId][$interactionId] = $interactionClass;
    }

    public static function registerInteractions(string $applicationId, array $interactions): void
    {
        self::$interactions[$applicationId] = array_merge(self::$interactions[$applicationId] ?? [], $interactions);
    }

    public static function registerApplication(string $applicationId, string $verificationKey): void
    {
        self::$applications[$applicationId] = $verificationKey;
    }

    public static function handle(array $requestData): DiscordResponse
    {
        if ($requestData['type'] === InteractionType::PING) {
            return new DiscordResponse(
                $requestData['application_id'],
                $requestData['id'],
                InteractionResponseType::PONG
            );
        }

        if ($requestData['type'] === InteractionType::MESSAGE_COMPONENT) {
            $interaction = Factory::interaction($requestData);

            if (! isset(self::$interactions[$interaction->getApplicationId()][$interaction->getCustomId()])) {
                throw new UnknownCommandException(
                    'A discord interaction was called that has not been configured',
                    1669135865,
                    applicationId: $interaction->getApplicationId(),
                    command: $interaction->getCustomId()
                );
            }

            $class = self::$interactions[$interaction->getApplicationId()][$interaction->getCustomId()];
            $class = new $class();

            if ($class instanceof InteractionInterface) {
                if (($class->deferInteractionResponse ?? false) === true) {
                    return new DeferredDiscordResponse(
                        $requestData['application_id'],
                        $requestData['id'],
                        InteractionResponseType::DEFERRED_UPDATE_MESSAGE,
                        null,
                        $interaction,
                        $requestData['token'],
                        $class::class,
                    );
                }

                return new DiscordResponse(
                    $requestData['application_id'],
                    $requestData['id'],
                    InteractionResponseType::UPDATE_MESSAGE,
                    new $class()->interaction($interaction),
                    $interaction,
                );
            }
        }

        if ($requestData['type'] === InteractionType::APPLICATION_COMMAND || $requestData['type'] === InteractionType::APPLICATION_COMMAND_AUTOCOMPLETE) {
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

            if ($class instanceof SlashCommandInterface && $requestData['type'] === InteractionType::APPLICATION_COMMAND) {
                if (($class->deferResponse ?? false) === true) {
                    return new DeferredDiscordResponse(
                        $requestData['application_id'],
                        $requestData['id'],
                        InteractionResponseType::DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE,
                        null,
                        $interaction,
                        $requestData['token'],
                        $class::class,
                    );
                }

                return new DiscordResponse(
                    $requestData['application_id'],
                    $requestData['id'],
                    InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE,
                    new $class()->slashCommand($interaction),
                    $interaction,
                );
            } elseif ($class instanceof AutoCompleteInterface && $requestData['type'] === InteractionType::APPLICATION_COMMAND_AUTOCOMPLETE) {
                return new DiscordResponse(
                    $requestData['application_id'],
                    $requestData['id'],
                    InteractionResponseType::APPLICATION_COMMAND_AUTOCOMPLETE_RESULT,
                    new $class()->autoComplete($interaction)->limit(),
                );
            }
        }

        throw new InvalidInteractionTypeException(
            'Discord interaction was not resolvable to a class',
            1669136019,
            applicationId: $interaction->getApplicationId(),
            type: $requestData['type'],
            command: $interaction instanceof SlashCommandInteraction ? $interaction->getName() : $interaction->getCustomId()
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
