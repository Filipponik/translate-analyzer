<?php

declare(strict_types=1);

namespace Filipponik\TranslateAnalyzer;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use SplFileInfo;

class DirectoryAnalyzer
{
    /**
     * Parse directory to find files with translating keys
     *
     * @param string $path
     * @param array $inputArr
     * @param string $suffix
     * @return array
     */
    public static function getKeysFromDirectory(string $path, array $inputArr, string $suffix): array
    {
        $iterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        do {
            $fileName = $iterator->getFilename();
            if ($fileName === '') {
                break;
            }

            if ($iterator->isReadable() && $iterator->isFile()) {
                if (!$suffix || $iterator->getExtension() !== $suffix) {
                    continue;
                }
                $file = $iterator->openFile();
                $inputArr = array_merge($inputArr, self::getKeysFromFile($file));
            } elseif ($iterator->isDir()) {
                $inputArr = self::getKeysFromDirectory($path . '/' . $iterator->getFilename(), $inputArr, $suffix);
            }
            $iterator->next();
        } while (true);

        return $inputArr;
    }

    /**
     * Parse file to find __('translating.keys')
     *
     * @param SplFileInfo $fileInfo
     * @return array
     */
    public static function getKeysFromFile(SplFileInfo $fileInfo): array
    {
        $re = '/__\(\'[A-z\s.]+\'/m';
        $arr = [];
        do {
            $string = $fileInfo->fgets();
            preg_match_all($re, $string, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $arr = array_merge($arr, $match);
            }
        } while (!$fileInfo->eof());

        return $arr;
    }
}
