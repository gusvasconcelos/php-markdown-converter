<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class CodeSyntax implements MarkdownSyntaxInterface
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public static function make(string $code): self
    {
        return new self($code);
    }

    public function getType(): string
    {
        return 'code';
    }
    
    public function __toString(): string
    {
        return "`{$this->code}`";
    }
}
