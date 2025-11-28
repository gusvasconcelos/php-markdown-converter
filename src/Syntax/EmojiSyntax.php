<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class EmojiSyntax implements MarkdownSyntaxInterface
{
    private string $emoji;

    public function __construct(string $emoji)
    {
        $this->emoji = $emoji;
    }

    public static function make(string $emoji): self
    {
        return new self($emoji);
    }

    public function getType(): string
    {
        return 'emoji';
    }

    public function __toString(): string
    {
        return $this->emoji;
    }
}
