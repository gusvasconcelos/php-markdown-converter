<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class OrderedListSyntax implements MarkdownSyntaxInterface
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
        return 'ordered_list';
    }
    
    public function __toString(): string
    {
        return implode(
            "\n", 
            array_map(fn($item, $index) => ($index + 1) . ". {$item}", $this->items, array_keys($this->items))
        );
    }
}
