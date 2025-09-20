<?php

namespace GusVasconcelos\MarkdownConverter;

class MarkdownConverter
{
    private array $content;

    public function __construct() 
    {
        $this->content = [];
    }

    public function heading(string $text, int $level = 1): self
    {
        $prefix = str_repeat('#', $level);

        $this->content[] = "{$prefix} {$text}";

        return $this;
    }

    public function horizontalRule(): self
    {
        $this->content[] = PHP_EOL . "---" . PHP_EOL;

        return $this;
    }

    public function paragraph(string $text): self
    {
        $this->content[] = $text;

        return $this;
    }

    public function codeBlock(string $code, string $language = ""): self
    {
        $this->content[] = "```{$language}\n{$code}\n```";

        return $this;
    }

    public function link(string $url, string $text): self
    {
        $this->content[] = "[{$text}]({$url})";

        return $this;
    }

    public function orderedList(array $items): self
    {
        $this->content[] = implode(
            PHP_EOL, 
            array_map(fn($item, $index) => "{$index}. {$item}", $items, range(1, count($items)))
        );

        return $this;
    }

    public function unorderedList(array $items): self
    {
        $this->content[] = implode(PHP_EOL, array_map(fn($item) => "- {$item}", $items));

        return $this;
    }

    public function write(string $directory, string $filename): self
    {
        $directory = rtrim($directory, '/');

        $content = implode(PHP_EOL, $this->content);

        $filePath = $directory . '/' . $filename . '.md';
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        file_put_contents($filePath, $content);
        
        return $this;
    }
    
    public function getContent(): string
    {
        return implode(PHP_EOL, $this->content);
    }
}
