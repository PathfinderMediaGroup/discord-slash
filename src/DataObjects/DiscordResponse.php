<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

use Discord\InteractionResponseFlags;
use Discord\InteractionResponseType;

class DiscordResponse implements \JsonSerializable
{
    public function __construct(
        protected string $applicationId,
        protected string $interactionId,
        protected int $type,
        protected Message|AutoCompleteCollection|null $data = null,
        protected Interaction|SlashCommandInteraction|null $interaction = null,
    ) {
    }
    public function getApplicationId(): string
    {
        return $this->applicationId;
    }

    public function getInteractionId(): string
    {
        return $this->interactionId;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getData(): Message|AutoCompleteCollection|null
    {
        return $this->data;
    }

    public function getInteraction(): Interaction|SlashCommandInteraction|null
    {
        return $this->interaction;
    }

    public function jsonSerialize(): array
    {
        if ($this->data instanceof Message) {
            return [
                'type' => $this->type,
                'data' => $this->data->jsonSerialize(),
            ];
        }
        if ($this->data instanceof AutoCompleteCollection) {
            return [
                'type' => $this->type,
                'data' => [
                    'choices' => $this->data->jsonSerialize(),
                ],
            ];
        }
        if ($this->type === InteractionResponseType::DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE) {
            return [
                'type' => $this->type,
//                'data' => [
//                    'tss' => false,
//                    'content' => 'Thinking...',
//                    'embeds' => [],
//                    'components' => [],
//                    'flags' => InteractionResponseFlags::EPHEMERAL,
//                ],
            ];
        }

        return [
            'type' => $this->type,
        ];
    }
}
