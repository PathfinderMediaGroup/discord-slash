<?php

declare(strict_types=1);

namespace PathfinderMediaGroup\DiscordSlash\DataObjects;

use DateTimeInterface;
use Discord\InteractionResponseFlags;

final class Message implements \JsonSerializable
{
    private ?string $content = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $url = null;
    private ?int $color = 3447003;
    private ?DateTimeInterface $timestamp = null;
    private ?string $footer_icon = null;
    private ?string $footer_text = null;
    private ?string $thumbnail = null;
    private ?string $image = null;
    private ?string $author_name = null;
    private ?string $author_url = null;
    private ?string $author_icon = null;
    private array $fields = [];
    private bool $tts = false;
    private array $actionRows = [];
    private array $mentions = [];
    private bool $textOnly = false;
    private array $textMentions = [];
    private ?int $flags = null;

    public function jsonSerialize(): array
    {
        return [
            'content' => (count($this->textMentions) > 0 ? (implode(' ', array_unique($this->textMentions)).' ') : '').$this->content,
            'components' => $this->actionRows,
            'tts' => $this->tts,
            'flags' => $this->flags,
            'embeds' => $this->textOnly ? [] : [[
                'title' => $this->title,
                'description' => $this->description,
                'timestamp' => $this->timestamp?->format(DateTimeInterface::ATOM),
                'url' => $this->url,
                'color' => $this->color,
                'author' => [
                    'name' => $this->author_name,
                    'url' => $this->author_url,
                    'icon_url' => $this->author_icon,
                ],
                'image' => [
                    'url' => $this->image,
                ],
                'thumbnail' => [
                    'url' => $this->thumbnail,
                ],
                'fields' => $this->fields,
                'footer' => [
                    'text' => $this->footer_text,
                    'icon_url' => $this->footer_icon,
                ],
            ]],
        ];
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function appendDescription(string $string): self
    {
        $this->description = ($this->description ?? '').$string;

        return $this;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setColor(?int $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function setTimestamp(?DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function setFooterIcon(?string $footer_icon): self
    {
        $this->footer_icon = $footer_icon;

        return $this;
    }

    public function setFooterText(?string $footer_text): self
    {
        $this->footer_text = $footer_text;

        return $this;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setAuthorName(?string $author_name): self
    {
        $this->author_name = $author_name;

        return $this;
    }

    public function setAuthorUrl(?string $author_url): self
    {
        $this->author_url = $author_url;

        return $this;
    }

    public function setAuthorIcon(?string $author_icon): self
    {
        $this->author_icon = $author_icon;

        return $this;
    }

    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function setTts(bool $tts): self
    {
        $this->tts = $tts;

        return $this;
    }

    public function withTimeStamp(): self
    {
        $this->timestamp = new \DateTime('now');

        return $this;
    }

    public function addField(string $name, string $value, bool $inLine = false): self
    {
        $this->fields[] = ['name' => $name, 'value' => $value, 'inline' => $inLine];

        return $this;
    }

    public function replaceFieldValue(string $name, string $newValue): self
    {
        foreach ($this->fields as $key => $value) {
            if ($value['name'] === $name) {
                $this->fields[$key]['value'] = $newValue;
            }
        }

        return $this;
    }

    public function getFieldValue(string $name): ?string
    {
        foreach ($this->fields as $value) {
            if ($value['name'] === $name) {
                return $value['value'];
            }
        }

        return null;
    }

    /**
     * @return ActionRow[]
     */
    public function getActionRows(): array
    {
        return $this->actionRows;
    }

    public function addActionRow(ActionRow $actionRow): self
    {
        $this->actionRows[] = $actionRow;

        return $this;
    }

    public function setActionRows(array $actionRows): self
    {
        $this->actionRows = array_filter($actionRows, static fn ($e) => $e instanceof ActionRow);

        return $this;
    }

    public function getMentions(): array
    {
        return $this->mentions;
    }

    public function setMentions(array $mentions): self
    {
        $this->mentions = $mentions;

        return $this;
    }

    public function wasMentioned(string $id): bool
    {
        return in_array($id, $this->mentions, true);
    }

    public function getCommand(): ?string
    {
        if (str_contains($this->footer_text ?? '', '!')) {
            return trim(explode(' ', explode('!', $this->footer_text)[1])[0]);
        }

        return null;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getColor(): ?int
    {
        return $this->color;
    }

    public function getTimestamp(): ?DateTimeInterface
    {
        return $this->timestamp;
    }

    public function getFooterIcon(): ?string
    {
        return $this->footer_icon;
    }

    public function getFooterText(): ?string
    {
        return $this->footer_text;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getAuthorName(): ?string
    {
        return $this->author_name;
    }

    public function getAuthorUrl(): ?string
    {
        return $this->author_url;
    }

    public function getAuthorIcon(): ?string
    {
        return $this->author_icon;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function isTts(): bool
    {
        return $this->tts;
    }

    public function setTextOnly(bool $textOnly) : self
    {
        $this->textOnly = $textOnly;

        return $this;
    }

    public function onlyVisibleToUserWhoInvoked(): self
    {
        $this->flags = InteractionResponseFlags::EPHEMERAL;

        return $this;
    }

    public function addTextMentions(array $userIds = [], array $roleIds = []): self
    {
        foreach ($userIds as $userId) {
            $this->textMentions[] = '<@'.$userId.'>';
        }
        foreach ($roleIds as $roleId) {
            $this->textMentions[] = '<@&'.$roleId.'>';
        }

        return $this;
    }
}
