<?php

namespace GusVasconcelos\MarkdownConverter\Syntax;

class ImageSyntax implements MarkdownSyntaxInterface
{
    private string $url;

    private string $altText;

    private ?string $title;

    public function __construct(string $url, string $altText, ?string $title = null)
    {
        $this->url = $url;
        
        $this->altText = $altText;

        $this->title = $title;
    }

    public static function make(string $url, string $altText, ?string $title = null): self
    {
        return new self($url, $altText, $title);
    }
    
    public function getType(): string
    {
        return 'image';
    }
    
    public function __toString(): string
    {
        $result = "![{$this->altText}]({$this->url}";
        
        if ($this->title !== null) {
            $result .= " \"{$this->title}\"";
        }
        
        $result .= ")";
        
        return $result;
    }
}
