<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class HorizontalRuleSyntax implements MarkdownSyntaxInterface
{
    public function __construct()
    {
    }

    public static function make(): self
    {
        return new self();
    }

    public function getType(): string
    {
        return 'horizontal_rule';
    }

    public function __toString(): string
    {
        return "\n---\n";
    }
}
