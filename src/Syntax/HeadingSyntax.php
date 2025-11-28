<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class HeadingSyntax implements MarkdownSyntaxInterface
{
    private string $text;

    private int $level;

    public function __construct(string $text, int $level = 1)
    {
        $this->text = $text;

        $this->level = max(1, min(6, $level));
    }

    public static function make(string $text, int $level = 1): self
    {
        return new self($text, $level);
    }
    
    public function getType(): string
    {
        return 'heading';
    }
    
    public function __toString(): string
    {
        $prefix = str_repeat('#', $this->level);

        return "{$prefix} {$this->text}";
    }
}
