# Translate analyzer

## Installing

```shell
composer require filipponik/translate-analyzer --dev
```

## Usage

1. Use `pwd` to get needed directory, or use `__DIR__` in code.
```
$ pwd
/home/user/project
```

2. Set your directory path, analyze some folder recursively and create language files.
```php
$analyzer = new \Filipponik\TranslateAnalyzer\Analyzer();
$analyzer
    ->setDirectoryPath('/home/user/project')
    // Analyze only .php files
    ->setSuffix('php')
    // Analyze directory ../app
    ->analyze('app')
    // Write to laravel 8- file structure
    ->toLaravel8AndBefore(['en', 'es', 'ch'])
    // Write to laravel 9+ file structure
    ->toLaravel9AndAbove(['en', 'es', 'ch'])
    // Or write lang files to selected directory
    ->writeResultsToFiles('my_lang_files');
```