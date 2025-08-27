# Agent Guidelines for Club Registration Form

## Build/Lint/Test Commands

### Testing
- **Run all tests**: `phpunit`
- **Run single test file**: `phpunit tests/step_tests.php`
- **Run step-specific tests**: `php tests/step_tests.php`
- **Check structure**: `php tests/structure_test.php`
- **Validate git tags**: `php tests/tag_validator.php`

### PHP Syntax & Linting
- **Check PHP syntax**: `php -l <filename>.php`
- **Install dependencies**: `composer install`

## Code Style Guidelines

### PHP
- **Autoloading**: PSR-4 with `Assignment\` namespace for src/, `Tests\` for tests/
- **Classes**: PascalCase class names, camelCase methods and properties
- **Variables**: camelCase, descriptive names
- **Indentation**: 4 spaces (consistent with existing code)
- **Comments**: PHPDoc style for classes/functions, inline comments for complex logic
- **Error Handling**: Use `filter_var()` for email validation, `empty()` for required fields
- **Arrays**: Use short array syntax `[]` when possible
- **Control Structures**: Always use braces, consistent formatting

### HTML
- **Structure**: Semantic HTML5 with proper DOCTYPE
- **Attributes**: Lowercase, quoted values
- **Forms**: POST method, action pointing to `process.php`
- **Accessibility**: Proper labels, semantic elements

### CSS
- **Organization**: Group related styles, use comments for sections
- **Properties**: At least 3+ properties per element (color, background, padding, etc.)
- **Naming**: Lowercase with hyphens for classes/IDs
- **Responsive**: Consider mobile-friendly design

### Testing
- **Framework**: PHPUnit with custom test runners
- **Structure**: One class per test file, descriptive method names
- **Assertions**: Clear pass/fail messages
- **Coverage**: Test all step requirements thoroughly

### Git Workflow
- **Tagging**: Use `git tag step-N` when tests pass
- **Commits**: Clear, descriptive messages
- **Pushing**: `git push && git push --tags`

### Security
- **Input Validation**: Always validate and sanitize user input
- **XSS Prevention**: Escape output when displaying user data
- **File Operations**: Validate file paths and permissions

### Performance
- **Arrays**: Use efficient array operations
- **Loops**: Prefer foreach for arrays, avoid nested loops when possible
- **Memory**: Consider large datasets when implementing storage

## Project Structure
```
club-registration-form/
├── index.html          # Main form page
├── styles.css          # Stylesheet
├── process.php         # Form processing script
├── composer.json       # PHP dependencies
├── phpunit.xml         # Test configuration
└── tests/              # Test files
    ├── step_tests.php
    ├── structure_test.php
    └── ...
```</content>
</xai:function_call/>
</xai:function_call name="bash">
<parameter name="command">cd /Applications/ServBay/www/club-registration-form-dariengolden && php -l AGENTS.md