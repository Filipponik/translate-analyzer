<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

class Analyzer
{
    private string $directoryPath = '';

    private array $foundKeys = [];

    private array $incorrectKeys = [];

    private string $suffix = '';

    /**
     * Analyze some directory
     */
    public function analyze(string $path): self
    {
        $keys = array_unique(DirectoryAnalyzer::getKeysFromDirectory($path, [], $this->suffix));
        sort($keys);
        $this->createCorrectKeysArray($keys);

        return $this;
    }

    /**
     * Create array from dot notation keys array
     */
    private function createCorrectKeysArray(array $inputKeys): void
    {
        foreach ($inputKeys as $inputKey) {
            $currentKeys = [];
            if (mb_strpos($inputKey, '.')) {
                Helper::fillArrayWithDotNotation($currentKeys, $inputKey, $inputKey);
                $this->foundKeys = array_merge_recursive($this->foundKeys, $currentKeys);
            } else {
                $this->incorrectKeys[] = $inputKey;
            }
        }
    }

    public function writeResultsToFiles(string $directoryName = 'analyze_results'): self
    {
        Formatter::createTranslationFiles($directoryName, $this->foundKeys, $this->incorrectKeys);

        return $this;
    }

    public function writeResultsToLaravelFiles(array $languages, $prefix): self
    {
        foreach ($languages as $languageName) {
            $filename = $this->directoryPath . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR . $languageName;
            Formatter::createTranslationFiles($filename, $this->foundKeys, $this->incorrectKeys);
        }

        return $this;
    }

    public function toLaravel8AndBefore(array $languages, $prefix = 'resources/lang'): self
    {
        return $this->writeResultsToLaravelFiles($languages, $prefix);
    }

    public function toLaravel9AndAbove(array $languages, $prefix = 'lang'): self
    {
        return $this->writeResultsToLaravelFiles($languages, $prefix);
    }

    public function getFoundKeys(): array
    {
        return $this->foundKeys;
    }

    public function getIncorrectKeys(): array
    {
        return $this->incorrectKeys;
    }

    public function setSuffix(string $suffix): self
    {
        $this->suffix = $suffix;
        return $this;
    }

    public function setDirectoryPath(string $directoryPath): self
    {
        $this->directoryPath = $directoryPath;
        return $this;
    }
}
