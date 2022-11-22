<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\Factories;

use PathfinderMediaGroup\DiscordSlash\DataObjects\ActionRow;
use PathfinderMediaGroup\DiscordSlash\DataObjects\Button;
use PathfinderMediaGroup\DiscordSlash\DataObjects\Interaction;
use PathfinderMediaGroup\DiscordSlash\DataObjects\Message;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SelectMenu;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SelectOption;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandInteraction;
use PathfinderMediaGroup\DiscordSlash\DataObjects\SlashCommandOption;

final class Factory
{
    public static function interaction(array $data): Interaction
    {
        return (new Interaction())
            ->setApplicationId($data['application_id'])
            ->setChannelId($data['channel_id'])
            ->setComponentType($data['data']['component_type'])
            ->setCustomId($data['data']['custom_id'])
            ->setGuildId($data['guild_id'])
            ->setUserId($data['member']['user']['id'])
            ->setValues($data['data']['values'] ?? [])
            ->setMessage(self::message($data['message']));
    }

    public static function slashCommandInteraction(array $data): SlashCommandInteraction
    {
        $interaction = (new SlashCommandInteraction())
            ->setName($data['data']['name'])
            ->setUserId($data['member'] ?? false ? $data['member']['user']['id'] : $data['user']['id'])
            ->setGuildId($data['guild_id'] ?? null)
            ->setChannelId($data['channel_id'])
            ->setApplicationId($data['application_id'])
            ->setDm(! isset($data['member']))
            ->setUserPermissions($data['member']['permissions'] ?? null);
        foreach ($data['data']['options'] ?? [] as $o) {
            $interaction->addOption(
                (new SlashCommandOption())
                    ->setName($o['name'])
                    ->setType($o['type'])
                    ->setValue($o['value'])
                    ->setFocussed($o['focused'] ?? false)
            );
        }

        return $interaction;
    }

    public static function message(array $data): Message
    {
        if (isset($data['embed']) && ! empty($data['embed'])) {
            $data['embeds'][0] = $data['embed'];
        }
        $message = (new Message())
            ->setContent($data['content'] ?? null)
            ->setTts($data['tts'] ?? false)
            ->setTitle($data['embeds'][0]['title'] ?? null)
            ->setDescription($data['embeds'][0]['description'] ?? null)
            ->setTimestamp(! isset($data['embeds'][0]['timestamp']) ? null : new \DateTime($data['embeds'][0]['timestamp']))
            ->setUrl($data['embeds'][0]['url'] ?? null)
            ->setColor($data['embeds'][0]['color'] ?? null)
            ->setAuthorName($data['embeds'][0]['author']['name'] ?? null)
            ->setAuthorUrl($data['embeds'][0]['author']['url'] ?? null)
            ->setAuthorIcon($data['embeds'][0]['author']['icon_url'] ?? null)
            ->setImage($data['embeds'][0]['image']['url'] ?? null)
            ->setThumbnail($data['embeds'][0]['thumbnail']['url'] ?? null)
            ->setFields($data['embeds'][0]['fields'] ?? [])
            ->setFooterIcon($data['embeds'][0]['footer']['icon_url'] ?? null)
            ->setFooterText($data['embeds'][0]['footer']['text'] ?? null)
            ->setMentions(array_map(static fn (array $element) => $element['id'], $data['mentions'] ?? []));

        $actionRows = [];
        foreach ($data['components'] ?? [] as $actionRow) {
            $actionRows[] = self::actionRow($actionRow);
        }

        return $message->setActionRows($actionRows);
    }

    public static function actionRow(array $data): ActionRow
    {
        $row = new ActionRow();
        $components = [];
        foreach ($data['components'] ?? [] as $component) {
            if ($component['type'] === Button::TYPE) {
                $components[] = self::button($component);
            } elseif ($component['type'] === SelectMenu::TYPE) {
                $components[] = self::selectMenu($component);
            }
        }

        return $row->setComponents($components);
    }

    public static function selectMenu(array $data): SelectMenu
    {
        $menu = (new SelectMenu())
            ->setCustomId($data['custom_id'])
            ->setPlaceHolder($data['placeholder'] ?? null)
            ->setMinValues($data['min_values'] ?? null)
            ->setMaxValues($data['max_values'] ?? null)
            ->setDisabled($data['disabled'] ?? false);

        foreach ($data['options'] ?? [] as $option) {
            $menu->addOption(self::selectOption($option));
        }

        return $menu;
    }

    public static function selectOption(array $data): SelectOption
    {
        return (new SelectOption())
            ->setLabel($data['label'])
            ->setValue($data['value'])
            ->setDescription($data['description'] ?? null)
            ->setDefault($data['default'] ?? null);
    }

    public static function button(array $data): Button
    {
        return (new Button())
            ->setCustomId($data['custom_id'] ?? null)
            ->setUrl($data['url'] ?? null)
            ->setDisabled($data['disabled'] ?? false)
            ->setLabel($data['label'])
            ->setStyle($data['style']);
    }
}
