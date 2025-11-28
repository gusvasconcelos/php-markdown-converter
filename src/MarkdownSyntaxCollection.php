<?php

namespace GusVasconcelos\MarkdownConverter;

use GusVasconcelos\MarkdownConverter\Syntax\MarkdownSyntaxInterface;
use Countable;

class MarkdownSyntaxCollection implements Countable
{
    private array $elements = [];

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    public static function make(array $elements = []): self
    {
        return new self($elements);
    }

    /**
     * Add an element to the collection
     */
    public function add(MarkdownSyntaxInterface $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Remove an element by position
     */
    public function removeAt(int $position): self
    {
        if ($this->has($position)) {
            array_splice($this->elements, $position, 1);
        }
        
        return $this;
    }

    /**
     * Get an element by position
     */
    public function get(int $position): ?MarkdownSyntaxInterface
    {
        return $this->elements[$position] ?? null;
    }

    /**
     * Check if an element exists at the position
     */
    public function has(int $position): bool
    {
        return isset($this->elements[$position]);
    }

    /**
     * Clear all elements
     */
    public function clear(): self
    {
        $this->elements = [];

        return $this;
    }

    /**
     * Return all elements
     */
    public function all(): array
    {
        return $this->elements;
    }

    /**
     * Replace an element at the specified position
     */
    public function replace(int $position, MarkdownSyntaxInterface $element): self
    {
        if ($this->has($position)) {
            $this->elements[$position] = $element;
        }
        
        return $this;
    }

    /**
     * Count the number of elements in the collection
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Convert all elements to Markdown
     */
    public function __toString(): string
    {
        return implode("\n", array_map(fn($element) => (string) $element, $this->elements));
    }
}
