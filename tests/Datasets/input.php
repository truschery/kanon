<?php

declare(strict_types=1);

function _loadInputDatasetsJson(string $fileName): array
{
    $path = __DIR__ . sprintf('/input/%s', $fileName);
    if(! file_exists($path)) {
        throw new Exception('File not found: ' . $path);
    }

    if(! is_readable($path)) {
        throw new Exception('File is not readable: ' . $path);
    }

    $contents = file_get_contents($path);
    return [json_decode(trim($contents))];
}

dataset('input.arrays', [_loadInputDatasetsJson('arrays.json')]);
dataset('input.structures', [_loadInputDatasetsJson('structures.json')]);
dataset('input.french', [_loadInputDatasetsJson('french.json')]);
dataset('input.unicode', [_loadInputDatasetsJson('unicode.json')]);
dataset('input.values', [_loadInputDatasetsJson('values.json')]);
dataset('input.weird', [_loadInputDatasetsJson('weird.json')]);