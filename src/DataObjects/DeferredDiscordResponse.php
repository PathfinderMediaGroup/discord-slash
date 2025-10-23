<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

class DeferredDiscordResponse extends DiscordResponse
{
    public function __construct(
        protected string $applicationId,
        protected string $interactionId,
        protected int $type,
        protected Message|AutoCompleteCollection|null $data = null,
        protected Interaction|SlashCommandInteraction|null $interaction = null,
        protected string $interactionToken,
        protected string $handlerClass,
    ) {
        parent::__construct($applicationId, $interactionId, $type, $data, $interaction);
    }

    public function getInteractionToken(): string
    {
        return $this->interactionToken;
    }

    public function getHandlerClass(): string
    {
        return $this->handlerClass;
    }
}
