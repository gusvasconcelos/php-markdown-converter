<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class ParagraphSyntax implements MarkdownSyntaxInterface
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public static function make(string $text): self
    {
        return new self($text);
    }

    public function getType(): string
    {
        return 'paragraph';
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
