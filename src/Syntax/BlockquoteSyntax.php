<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class BlockquoteSyntax implements MarkdownSyntaxInterface
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
        return 'blockquote';
    }
    
    public function __toString(): string
    {
        $lines = explode("\n", $this->text);

        $quotedLines = array_map(fn($line) => "> {$line}", $lines);

        return implode("\n", $quotedLines);
    }
}
