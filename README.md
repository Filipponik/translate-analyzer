# Translate analyzer

## Installing

```shell
composer require filipponik/translate-analyzer --dev
```

## Usage

```php
$analyzer = new \Filipponik\TranslateAnalyzer\Analyzer();
$analyzer
    // Analyze only .php files
    ->setSuffix('php')
    // Analyze directory ../app
    ->analyze('../app')
    // Write to laravel lang files (by default structure)
    ->writeResultsToLaravelFiles(['en', 'es', 'ch'])
    // Or write lang files to selected directory
    ->writeResultsToFiles('my_super_lang_files');
```