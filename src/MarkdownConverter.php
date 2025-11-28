<?php

namespace GusVasconcelos\MarkdownConverter;

use GusVasconcelos\MarkdownConverter\Syntax\{
    BoldSyntax,
    CodeSyntax,
    LinkSyntax,
    EmojiSyntax,
    ImageSyntax,
    ItalicSyntax,
    HeadingSyntax,
    CodeBlockSyntax,
    ParagraphSyntax,
    BlockquoteSyntax,
    OrderedListSyntax,
    UnorderedListSyntax,
    HorizontalRuleSyntax,
    MarkdownSyntaxInterface,
};

class MarkdownConverter
{
    private MarkdownSyntaxCollection $elements;

    public function __construct() 
    {
        $this->elements = MarkdownSyntaxCollection::make();
    }

    public static function make(): self
    {
        return new self();
    }

    /**
     * Add a heading to the content
     * @param string $text
     * @param int $level
     * @return self
     */
    public function heading(string $text, int $level = 1): self
    {
        $this->elements->add(HeadingSyntax::make($text, $level));

        return $this;
    }

    /**
     * Add a horizontal rule to the content
     * @return self
     */
    public function horizontalRule(): self
    {
        $this->elements->add(HorizontalRuleSyntax::make());

        return $this;
    }

    /**
     * Add a paragraph to the content
     * @param string $text
     * @return self
     */
    public function paragraph(string $text): self
    {
        $this->elements->add(ParagraphSyntax::make($text));

        return $this;
    }

    /**
     * Add a code block to the content
     * @param string $code
     * @param string $language
     * @return self
     */
    public function codeBlock(string $code, string $language = ""): self
    {
        $this->elements->add(CodeBlockSyntax::make($code, $language));

        return $this;
    }

    /**
     * Add a link to the content
     * @param string $url
     * @param string $text
     * @param string|null $title
     * @return self
     */
    public function link(string $url, string $text, ?string $title = null): self
    {
        $this->elements->add(LinkSyntax::make($url, $text, $title));

        return $this;
    }

    /**
     * Add an ordered list to the content
     * @param array $items
     * @return self
     */
    public function orderedList(array $items): self
    {
        $this->elements->add(OrderedListSyntax::make($items));

        return $this;
    }

    /**
     * Add an unordered list to the content
     * @param array $items
     * @return self
     */
    public function unorderedList(array $items): self
    {
        $this->elements->add(UnorderedListSyntax::make($items));

        return $this;
    }

    /**
     * Add bold text to the content
     * @param string $text
     * @return self
     */
    public function bold(string $text): self
    {
        $this->elements->add(BoldSyntax::make($text));

        return $this;
    }

    /**
     * Add italic text to the content
     * @param string $text
     * @return self
     */
    public function italic(string $text): self
    {
        $this->elements->add(ItalicSyntax::make($text));

        return $this;
    }

    /**
     * Add a blockquote to the content
     * @param string $text
     * @return self
     */
    public function blockquote(string $text): self
    {
        $this->elements->add(BlockquoteSyntax::make($text));

        return $this;
    }

    /**
     * Add an image to the content
     * @param string $url
     * @param string $altText
     * @param string|null $title
     * @return self
     */
    public function image(string $url, string $altText, ?string $title = null): self
    {
        $this->elements->add(ImageSyntax::make($url, $altText, $title));

        return $this;
    }

    /**
     * Add inline code to the content
     * @param string $code
     * @return self
     */
    public function code(string $code): self
    {
        $this->elements->add(CodeSyntax::make($code));

        return $this;
    }

    /**
     * Add an emoji to the content
     * @param string $emoji
     * @return self
     */
    public function emoji(string $emoji): self
    {
        $this->elements->add(EmojiSyntax::make($emoji));

        return $this;
    }

    /**
     * Remove an element by position
     * @param int $position
     * @return self
     */
    public function removeAt(int $position): self
    {
        $this->elements->removeAt($position);

        return $this;
    }

    /**
     * Get an element by position
     * @param int $position
     * @return MarkdownSyntaxInterface|null
     */
    public function get(int $position): ?MarkdownSyntaxInterface
    {
        return $this->elements->get($position);
    }

    /**
     * Replace an element at the specified position
     * @param int $position
     * @param MarkdownSyntaxInterface $element
     * @return self
     */
    public function replace(int $position, MarkdownSyntaxInterface $element): self
    {
        $this->elements->replace($position, $element);

        return $this;
    }

    /**
     * Return the collection of elements
     * @return MarkdownSyntaxCollection
     */
    public function all(): MarkdownSyntaxCollection
    {
        return $this->elements;
    }

    /**
     * Clear all elements
     * @return self
     */
    public function clear(): self
    {
        $this->elements->clear();

        return $this;
    }

    /**
     * Count the number of elements in the collection
     * @return int
     */
    public function count(): int
    {
        return $this->elements->count();
    }

    /**
     * Write the content to a file
     * @param string $directory
     * @param string $filename
     * @return self
     */
    public function write(string $directory, string $filename): self
    {
        $directory = rtrim($directory, '/');

        $content = (string) $this->elements;

        $filePath = $directory . '/' . $filename . '.md';
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        file_put_contents($filePath, $content);
        
        return $this;
    }
    
    /**
     * Return the content as string
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->elements;
    }
}
