<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class UnorderedListSyntax implements MarkdownSyntaxInterface
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function make(array $items = []): self
    {
        return new self($items);
    }

    public function getType(): string
    {
        return 'unordered_list';
    }

    public function __toString(): string
    {
        return implode("\n", array_map(fn($item) => "- {$item}", $this->items));
    }
}
