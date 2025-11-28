<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class CodeBlockSyntax implements MarkdownSyntaxInterface
{
    private string $code;

    private string $language;

    public function __construct(string $code, string $language = "")
    {
        $this->code = $code;

        $this->language = $language;
    }

    public static function make(string $code, string $language = ""): self
    {
        return new self($code, $language);
    }

    public function getType(): string
    {
        return 'code_block';
    }
    
    public function __toString(): string
    {
        return "```{$this->language}\n{$this->code}\n```";
    }
}
