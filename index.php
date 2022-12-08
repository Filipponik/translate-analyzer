<?php
declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

$analyzer = new \Filipponik\TranslateAnalyzer\Analyzer();
$analyzer->analyze('src/examples');
$analyzer->writeResultsToFiles();