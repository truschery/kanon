<?php

declare(strict_types=1);

function _loadOutputDatasetsJson(string $fileName): string
{
    $path = __DIR__ . sprintf('/output/%s', $fileName);
    if(! file_exists($path)) {
        throw new Exception('File not found: ' . $path);
    }

    if(! is_readable($path)) {
        throw new Exception('File is not readable: ' . $path);
    }

    $contents = file_get_contents($path);

    return trim($contents);
}

dataset('output.arrays', [_loadOutputDatasetsJson('arrays.json')]);
dataset('output.structures', [_loadOutputDatasetsJson('structures.json')]);
dataset('output.french', [_loadOutputDatasetsJson('french.json')]);
dataset('output.unicode', [_loadOutputDatasetsJson('unicode.json')]);
dataset('output.values', [_loadOutputDatasetsJson('values.json')]);
dataset('output.weird', [_loadOutputDatasetsJson('weird.json')]);