# PHP Markdown Converter

[![PHP Version](https://img.shields.io/packagist/php-v/gusvasconcelos/markdown-converter)](https://packagist.org/packages/gusvasconcelos/markdown-converter)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Latest Stable Version](https://img.shields.io/packagist/v/gusvasconcelos/markdown-converter)](https://packagist.org/packages/gusvasconcelos/markdown-converter)
![Downloads](https://img.shields.io/packagist/dt/gusvasconcelos/markdown-converter)


An elegant and fluent PHP library for generating structured Markdown content with support for all essential elements and advanced customization options.

## ✨ Features

- **Fluent Interface**: Chainable methods for intuitive document construction
- **Complete Support**: All essential Markdown elements supported
- **Element Management**: Easily manipulate, replace, and remove elements
- **Extensible Architecture**: Based on design patterns and SOLID principles
- **Zero Dependencies**: Independent and lightweight library
- **PSR-4 Compatible**: Standard autoloading

## 📦 Installation

Install via Composer:

```bash
composer require gusvasconcelos/markdown-converter
```

## ⚡ Requirements

- PHP 7.4 or higher
- Composer

## 🚀 Basic Usage

```php
use GusVasconcelos\MarkdownConverter\MarkdownConverter;

// Initialize the converter
$converter = new MarkdownConverter();

// Create markdown content
$converter
    ->heading('API Request Log')
    ->paragraph('Request ID: 1234567890')
    ->horizontalRule()
    ->codeBlock('{"name":"John","age":30,"email":"john@example.com"}', "json")
    ->link('https://api.example.com', 'API Documentation')
    ->write(__DIR__, "example"); // Writes to example.md file
```

### Fluent Interface
All methods return the converter instance, allowing method chaining:

```php
$document = (new MarkdownConverter())
    ->heading('System Log', 2)
    ->paragraph('Timestamp: ' . date('Y-m-d H:i:s'))
    ->horizontalRule()
    ->codeBlock($errorDetails, 'php')
    ->bold('Status: ')
    ->code('ERROR')
    ->paragraph('')
    ->blockquote('This is an important system message')
    ->link('https://support.example.com', 'Get Support')
    ->write(__DIR__, "system-log");
```

## 📋 Available Methods

### Text Elements

#### `heading(string $text, int $level = 1)`
Creates a heading with the specified text and level (1-6).
```php
$converter->heading('Main Title'); // # Main Title
$converter->heading('Subtitle', 2); // ## Subtitle
```

#### `paragraph(string $text)`
Adds a paragraph with the specified text.
```php
$converter->paragraph('This is an example paragraph.'); 
// This is an example paragraph.
```

#### `bold(string $text)`
Adds bold text.
```php
$converter->bold('Bold text'); // **Bold text**
```

#### `italic(string $text)`
Adds italic text.
```php
$converter->italic('Italic text'); // *Italic text*
```

#### `blockquote(string $text)`
Adds a block quote.
```php
$converter->blockquote('This is an important quote'); 
// > This is an important quote
```

### Code Elements

#### `code(string $code)`
Adds inline code.
```php
$converter->code('$variable = "value"'); // `$variable = "value"`
```

#### `codeBlock(string $code, string $language = "")`
Adds a code block with optional language.
```php
$converter->codeBlock('{"name":"John","age":30}', 'json');
// ```json
// {"name":"John","age":30}
// ```
```

### Media Elements

#### `image(string $url, string $altText, ?string $title = null)`
Adds an image with URL, alternative text and optional title.
```php
$converter->image('https://example.com/image.jpg', 'Alternative text', 'Title');
// ![Alternative text](https://example.com/image.jpg "Title")
```

#### `link(string $url, string $text, ?string $title = null)`
Adds a link with URL, text and optional title.
```php
$converter->link('https://example.com', 'Example Site', 'Visit our site');
// [Example Site](https://example.com "Visit our site")
```

### List Elements

#### `orderedList(array $items)`
Adds an ordered list with the specified items.
```php
$converter->orderedList(['Item 1', 'Item 2', 'Item 3']);
// 1. Item 1
// 2. Item 2
// 3. Item 3
```

#### `unorderedList(array $items)`
Adds an unordered list with the specified items.
```php
$converter->unorderedList(['Item 1', 'Item 2', 'Item 3']);
// - Item 1
// - Item 2
// - Item 3
```

### Structural Elements

#### `horizontalRule()`
Adds a horizontal rule (divider).
```php
$converter->horizontalRule(); // ---
```

#### `emoji(string $emoji)`
Adds an emoji to the content.
```php
$converter->emoji('😀'); // 😀
```

### Output Methods

#### `write(string $directory, string $filename)`
Writes the markdown content to a file.
```php
$converter->write(__DIR__, "document"); // Creates document.md
```

#### `__toString()`
Returns the markdown content as a string.
```php
$content = (string) $converter; // Gets all content
```

## 🔧 Element Management

The library provides advanced methods for manipulating individual elements:

### Manipulation Methods

#### `get(int $position)`
Gets an element by position.
```php
$converter->heading('Title')->paragraph('Text');
$element = $converter->get(0); // Gets the first element (heading)
```

#### `removeAt(int $position)`
Removes an element by position.
```php
$converter->heading('Title')->paragraph('Text 1')->paragraph('Text 2');
$converter->removeAt(1); // Removes "Text 1"
```

#### `replace(int $position, MarkdownSyntaxInterface $element)`
Replaces an element at a specific position.
```php
use GusVasconcelos\MarkdownConverter\Syntax\BoldSyntax;

$converter->heading('Title')->paragraph('Text');
$converter->replace(1, new BoldSyntax('Bold Text')); // Replaces the paragraph
```

#### `count()`
Returns the total number of elements.
```php
$converter->heading('Title')->paragraph('Text');
$total = $converter->count(); // Returns 2
```

#### `clear()`
Removes all elements from the collection.
```php
$converter->heading('Title')->paragraph('Text');
$converter->clear(); // Removes everything
```

#### `all()`
Returns the complete collection of elements.
```php
$elements = $converter->all(); // Gets MarkdownSyntaxCollection
```

### Practical Management Example

```php
$document = new MarkdownConverter();

// Build document
$document
    ->heading('Sales Report')
    ->paragraph('First quarter data')
    ->codeBlock('// Example code', 'php')
    ->paragraph('Detailed analysis');

// Check number of elements
echo "Total elements: " . $document->count(); // 4

// Replace code with a list
use GusVasconcelos\MarkdownConverter\Syntax\UnorderedListSyntax;
$list = new UnorderedListSyntax(['Sales: 100k', 'Profit: 25k', 'Customers: 500']);
$document->replace(2, $list);

// Remove last paragraph
$document->removeAt(3);

// Get final result
$finalContent = (string) $document;
```

## 💡 Use Cases

### 📋 Automated Reports
Create structured reports from system data:

```php
$report = new MarkdownConverter();

// Data from database
$sales = ['January' => 15000, 'February' => 18000, 'March' => 22000];
$topProducts = ['Product A', 'Product B', 'Product C'];

$report
    ->heading('Monthly Sales Report', 1)
    ->paragraph('Period: ' . date('Y-m-d'))
    ->emoji('📈')
    ->horizontalRule()
    
    ->heading('Executive Summary', 2)
    ->paragraph('Total quarterly sales: $' . number_format(array_sum($sales), 2))
    ->blockquote('Quarterly target achieved successfully!')
    
    ->heading('Sales by Month', 2)
    ->orderedList(array_map(function($month, $value) {
        return "$month: $" . number_format($value, 2);
    }, array_keys($sales), $sales))
    
    ->heading('Top Products', 2)
    ->unorderedList($topProducts)
    
    ->horizontalRule()
    ->italic('Report automatically generated on ' . date('m/d/Y H:i'))
    
    ->write(__DIR__, 'sales-report');
```

### 🐛 System Logs
Structure error and debug logs:

```php
$logger = new MarkdownConverter();

$logger
    ->heading('System Error Log', 1)
    ->paragraph('Timestamp: ' . date('Y-m-d H:i:s'))
    ->horizontalRule()
    
    ->heading('Critical Error', 2)
    ->bold('Level: ')
    ->code('CRITICAL')
    ->paragraph('Database connection failure.')
    ->codeBlock('PDOException: Connection refused', 'text')
    
    ->heading('Stack Trace', 3)
    ->codeBlock($stackTrace ?? 'Stack trace not available', 'php')
    
    ->heading('Recommended Action', 2)
    ->blockquote('Check connection settings and MySQL server status')
    
    ->write('/var/log/app/', 'error-' . date('Y-m-d'));
```

### 📧 Email Templates
Generate content for transactional emails:

```php
$emailTemplate = new MarkdownConverter();

$emailTemplate
    ->heading('Welcome to our platform!', 1)
    ->emoji('🎉')
    ->paragraph('Hello John, we\'re happy to have you with us!')
    
    ->heading('Next Steps', 2)
    ->orderedList([
        'Complete your profile',
        'Explore our features',
        'Contact us if you need help'
    ])
    
    ->horizontalRule()
    ->paragraph('Need help?')
    ->link('https://support.example.com', 'Help Center')
    
    ->paragraph('')
    ->italic('Example Team');

// Convert to HTML via Markdown parser
$htmlContent = $markdownParser->parse((string) $emailTemplate);
```

## 🧪 Testing

Run the test suite to ensure everything works correctly:

```bash
composer test
```

The library includes comprehensive tests covering:
- All Markdown syntax elements
- Element management operations
- File writing functionality
- Method chaining behavior
- Edge cases and error conditions

## 📄 License

This project is open-sourced under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

Contributions are welcome! For major changes, please open an issue first to discuss what you would like to change.

### Contributing Guidelines

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass (`composer test`)
6. Commit your changes (`git commit -m 'Add amazing feature'`)
7. Push to the branch (`git push origin feature/amazing-feature`)
8. Open a Pull Request

Please make sure to update tests as appropriate and follow the existing code style.
