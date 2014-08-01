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

    $fullQualifiedPathsWithFittingFiles = array();
    directoryWalker($basePath, $fullQualifiedPathsWithFittingFiles);

    $pathsAsArray = convertDirectoryWalkerResult($basePath, $fullQualifiedPathsWithFittingFiles);
    addGeneratedContent($content, $pathsAsArray, $baseUrl);

    return $content;
}

function addGeneratedContent(&$content, array $data, $baseUrl)
{
    foreach ($data as $path => $fileName) {
        $lines = getLinesFromFile($path . DIRECTORY_SEPARATOR . $fileName, 1);
        $content[] = '[' . substr($lines[0], 2) . '](' . $baseUrl . '/' . $path . ')';
    }
}

function convertDirectoryWalkerResult($basePath, array $array)
{
    $convertedArray = array();
    $lengthOfBasePath = strlen($basePath) + 1; //+1 for trailing directory slash

    foreach ($array as $fullQualifiedPath => $fileName) {
        $key = substr($fullQualifiedPath, $lengthOfBasePath);
        $convertedArray[$key] = $fileName;
    }

    return $convertedArray;
}

/**
 * @param string $basePath
 * @param array $array
 */
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


//take from: https://github.com/zendframework/zf2/blob/master/library/Zend/Stdlib/ArrayUtils.php
/**
 * Merge two arrays together.
 * If an integer key exists in both arrays and preserveNumericKeys is false, the value
 * from the second array will be appended to the first array. If both values are arrays, they
 * are merged together, else the value of the second array overwrites the one of the first array.
 * @param  array $arrayOne
 * @param  array $arrayTwo
 * @param  bool  $preserveNumericKeys
 * @return array
 */
function merge(array $arrayOne, array $arrayTwo, $preserveNumericKeys = false)
{
    foreach ($arrayTwo as $key => $value) {
        if (array_key_exists($key, $arrayOne)) {
            if (is_int($key) && !$preserveNumericKeys) {
                $arrayOne[] = $value;
            } elseif (is_array($value) && is_array($arrayOne[$key])) {
                $arrayOne[$key] = merge($arrayOne[$key], $value, $preserveNumericKeys);
            } else {
                $arrayOne[$key] = $value;
            }
        } else {
            $arrayOne[$key] = $value;
        }
    }

    return $arrayOne;
}
//end of update logic

//begin of file system utility
function getLinesFromFile($filePath, $numberOfLines)
{
    $content = explode("\n", file_get_contents($filePath));
    $lines = array_slice($content, 0, $numberOfLines);

    return $lines;
}

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

file_put_contents($filePath, implode("\n", $content));
