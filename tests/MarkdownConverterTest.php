<?php

namespace Tests\GusVasconcelos\MarkdownConverter;

use GusVasconcelos\MarkdownConverter\MarkdownConverter;
use GusVasconcelos\MarkdownConverter\Syntax\BoldSyntax;
use PHPUnit\Framework\TestCase;

class MarkdownConverterTest extends TestCase
{
    private $tempDir;

    protected function setUp(): void
    {
        $this->tempDir = sys_get_temp_dir() . '/markdown-converter-test-' . uniqid();

        mkdir($this->tempDir, 0777, true);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->tempDir)) {
            $files = glob($this->tempDir . '/*');

            foreach ($files as $file) {
                unlink($file);
            }

            rmdir($this->tempDir);
        }
    }

    public function testInitialization()
    {
        $converter = new MarkdownConverter();

        $this->assertInstanceOf(MarkdownConverter::class, $converter);
    }

    public function testHeading()
    {
        $converter = MarkdownConverter::make()
            ->heading('Test Heading');

        $this->assertStringContainsString('# Test Heading', (string) $converter);
    }

    public function testParagraph()
    {
        $converter = MarkdownConverter::make()
            ->paragraph('Test paragraph content');

        $this->assertStringContainsString('Test paragraph content', (string) $converter);
    }

    public function testHorizontalRule()
    {
        $converter = MarkdownConverter::make()
            ->horizontalRule();

        $this->assertStringContainsString('---', (string) $converter);
    }

    public function testCodeBlock()
    {
        $converter = MarkdownConverter::make()
            ->codeBlock('{"name": "John Doe", "age": 30}', 'json');

        $code = '{"name": "John Doe", "age": 30}';

        $this->assertStringContainsString("```json\n{\"name\": \"John Doe\", \"age\": 30}\n```", (string) $converter);
    }

    public function testLink()
    {
        $converter = MarkdownConverter::make()
            ->link('https://example.com', 'Example');

        $this->assertStringContainsString('[Example](https://example.com)', (string) $converter);
    }

    public function testOrderedList()
    {
        $converter = MarkdownConverter::make()
            ->orderedList(['Item 1', 'Item 2', 'Item 3']);

        $this->assertStringContainsString('1. Item 1', (string) $converter);

        $this->assertStringContainsString('2. Item 2', (string) $converter);

        $this->assertStringContainsString('3. Item 3', (string) $converter);
    }

    public function testUnorderedList()
    {
        $converter = MarkdownConverter::make()
            ->unorderedList(['Item 1', 'Item 2', 'Item 3']);

        $this->assertStringContainsString('- Item 1', (string) $converter);

        $this->assertStringContainsString('- Item 2', (string) $converter);

        $this->assertStringContainsString('- Item 3', (string) $converter);
    }

    public function testChainedMethods()
    {
        $content = MarkdownConverter::make()
            ->heading('Test Document')
            ->paragraph('This is a test paragraph')
            ->horizontalRule()
            ->codeBlock('echo "Hello";', 'php')
            ->orderedList(['Item 1', 'Item 2', 'Item 3'])
            ->unorderedList(['Item 1', 'Item 2', 'Item 3'])
            ->bold('Bold Text')
            ->italic('Italic Text')
            ->blockquote('This is a quote')
            ->image('https://example.com/image.jpg', 'Alt text', 'Title')
            ->code('inline code')
            ->emoji('😀')
            ->link('https://example.com', 'Example Site');

        $this->assertStringContainsString('# Test Document', $content);

        $this->assertStringContainsString('This is a test paragraph', $content);

        $this->assertStringContainsString('---', $content);

        $this->assertStringContainsString("```php\necho \"Hello\";\n```", $content);

        $this->assertStringContainsString('1. Item 1', $content);

        $this->assertStringContainsString('2. Item 2', $content);

        $this->assertStringContainsString('3. Item 3', $content);

        $this->assertStringContainsString('- Item 1', $content);

        $this->assertStringContainsString('- Item 2', $content);

        $this->assertStringContainsString('- Item 3', $content);

        $this->assertStringContainsString('**Bold Text**', $content);

        $this->assertStringContainsString('*Italic Text*', $content);

        $this->assertStringContainsString('> This is a quote', $content);

        $this->assertStringContainsString('![Alt text](https://example.com/image.jpg "Title")', $content);

        $this->assertStringContainsString('`inline code`', $content);
        
        $this->assertStringContainsString('😀', $content);

        $this->assertStringContainsString('[Example Site](https://example.com)', $content);
    }

    public function testWriteMethod()
    {
        $filename = 'build-test';

        $content = MarkdownConverter::make()
            ->heading('Build Test')
            ->paragraph('Testing build method')
            ->write($this->tempDir, $filename);

        $this->assertFileExists($this->tempDir . '/' . $filename . '.md');

        $this->assertStringContainsString('# Build Test', $content);

        $this->assertStringContainsString('Testing build method', $content);
    }

    public function testToString()
    {
        $content = MarkdownConverter::make()
            ->heading('Content Test')
            ->paragraph('Testing toString method');

        $this->assertIsString((string) $content);

        $this->assertStringContainsString('# Content Test', $content);

        $this->assertStringContainsString('Testing toString method', $content);
    }

    public function testBold()
    {
        $converter = MarkdownConverter::make()
            ->bold('Bold Text');

        $this->assertStringContainsString('**Bold Text**', (string) $converter);
    }

    public function testItalic()
    {
        $converter = MarkdownConverter::make()
            ->italic('Italic Text');

        $this->assertStringContainsString('*Italic Text*', (string) $converter);
    }

    public function testBlockquote()
    {
        $converter = MarkdownConverter::make()
            ->blockquote('This is a quote');

        $this->assertStringContainsString('> This is a quote', (string) $converter);
    }

    public function testImage()
    {
        $converter = MarkdownConverter::make()
            ->image('https://example.com/image.jpg', 'Alt text', 'Title');

        $this->assertStringContainsString('![Alt text](https://example.com/image.jpg "Title")', (string) $converter);
    }

    public function testImageWithoutTitle()
    {
        $converter = MarkdownConverter::make()
            ->image('https://example.com/image.jpg', 'Alt text');

        $this->assertStringContainsString('![Alt text](https://example.com/image.jpg)', (string) $converter);
    }

    public function testCode()
    {
        $converter = MarkdownConverter::make()
            ->code('inline code');

        $this->assertStringContainsString('`inline code`', (string) $converter);
    }

    public function testEmoji()
    {
        $converter = MarkdownConverter::make()
            ->emoji('😀');

        $this->assertStringContainsString('😀', (string) $converter);
    }

    public function testElementManagement()
    {
        $converter = MarkdownConverter::make()
            ->heading('Title')
            ->paragraph('Paragraph 1')
            ->paragraph('Paragraph 2');
        
        $this->assertEquals(3, $converter->count());
        
        $element = $converter->get(0);

        $this->assertEquals('heading', $element->getType());
        
        $converter->removeAt(1);

        $this->assertEquals(2, $converter->count());
        
        $converter->replace(1, BoldSyntax::make('Bold'));
        
        $this->assertEquals(2, $converter->count());
        
        $this->assertStringContainsString('**Bold**', (string) $converter);
    }

    public function testClearElements()
    {
        $converter = MarkdownConverter::make()
            ->heading('Title')
            ->paragraph('Content');

        $this->assertEquals(2, $converter->count());

        $converter->clear();

        $this->assertEquals(0, $converter->count());

        $this->assertStringContainsString('', (string) $converter);
    }
}
