#!/bin/php
<?php
/**
 * @author stev leibelt <artodeto@bazzline.net>
 * @since 2014-07-31
 * @todo put it in nice classes
 */

$baseUrl = 'https://github.com/stevleibelt/incubator/tree/master/';
$filePath = __DIR__ . '/README.md';
$identifierOfSectionsAndIdeas = '## Sections And Ideas';

//begin of update logic
/**
 * @param string $identifier
 * @param string $filePath
 * @return array
 */
function fetchContentThatShouldNotBeUpdated($identifier, $filePath)
{
    $contentOfReadme = explode("\n", file_get_contents($filePath));
    $contentBeforeIdentifier = array();

    foreach ($contentOfReadme as $content) {
        if ($content !== $identifier) {
            $contentBeforeIdentifier[] = $content;
        } else {
            break;
        }
    }

    return $contentBeforeIdentifier;
}

/**
 * @param string $identifier
 * @param string $basePath
 * @param string $baseUrl
 * @return array
 */
function createContentThatShouldBeUpdated($identifier, $basePath, $baseUrl)
{
    $content = array();

    $content[] = $identifier;
    $content[] = '';

    $array = array();
    directoryWalker($basePath, $array);
echo __METHOD__ . ' ' . var_export($array, true) . PHP_EOL;

    return $content;
}

function directoryWalker($basePath, array &$array)
{
    $matchingSuffix = '.md';

    $directoryNames = getDirectoryNames($basePath);
    $subPathsToSearchIn = array();

    foreach ($directoryNames as $directoryName) {
        $foundMatchingSuffixInDirectory = false;
        $path = $basePath . DIRECTORY_SEPARATOR . $directoryName;
        $fileNames = getFileNames($path);

        foreach ($fileNames as $fileName) {
            if (stringEndsWith($fileName, $matchingSuffix)) {
                $array[$path] = $fileName;
                $foundMatchingSuffixInDirectory = true;
                break;
            }
        }

        if (!$foundMatchingSuffixInDirectory) {
            $subPathsToSearchIn[] = $path;
        }
    }

    foreach ($subPathsToSearchIn as $pathToSearchIn) {
        directoryWalker($pathToSearchIn, $array);
    }
}
//end of update logic

//begin of file system utility
/**
 * @param string $basePath
 * @return array
 */
function getFileNames($basePath)
{
    $names = array();

    if ($directoryHandle = opendir($basePath)) {
        while (false !== ($fileSystemIdentifier = readdir($directoryHandle))) {
            if (is_file($basePath . DIRECTORY_SEPARATOR . $fileSystemIdentifier)) {
                $names[] = $fileSystemIdentifier;
            }
        }
        closedir($directoryHandle);
    }

    return $names;
}

/**
 * @param string $basePath
 * @return array
 */
function getDirectoryNames($basePath)
{
    $names = array();

    if ($directoryHandle = opendir($basePath)) {
        $blacklistedDirectoryNames = array(
            '.',
            '..',
            '.svn',
            '.git',
            '.idea',
            'vendor'
        );
        while (false !== ($fileSystemIdentifier = readdir($directoryHandle))) {
            if (is_dir($basePath . DIRECTORY_SEPARATOR . $fileSystemIdentifier)) {
                if (!in_array($fileSystemIdentifier, $blacklistedDirectoryNames)) {
                    $names[] = $fileSystemIdentifier;
                }
            } else {
            }
        }
        closedir($directoryHandle);
    }

    return $names;
}
//end of file system utility

//begin of string utility
/**
 * @param string $haystack
 * @param string $needle
 * @return bool
 */
function stringEndsWith($haystack, $needle)
{
    return (substr($haystack, -(strlen($needle))) === $needle);
}
//end of string utility

//starting generation

$content = array_merge(
    fetchContentThatShouldNotBeUpdated(
        $identifierOfSectionsAndIdeas,
        $filePath
    ),
    createContentThatShouldBeUpdated(
        $identifierOfSectionsAndIdeas,
        __DIR__,
        $baseUrl
    )
);

//echo var_export($content, true) . PHP_EOL;
