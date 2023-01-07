# Translate analyzer

## Installing

```shell
composer require filipponik/translate-analyzer --dev
```

## Usage

```php
$analyzer = new \Filipponik\TranslateAnalyzer\Analyzer();

// Analyze custom directory
$analyzer->analyze('../app');

// Write to laravel lang files (by default structure)
$analyzer->writeResultsToLaravelFiles(['en', 'es', 'ch']);

// Write lang files to selected directory
$analyzer->writeResultsToFiles('my_super_lang_files');
```