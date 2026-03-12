<?php

declare(strict_types=1);

use Truschery\Kanon\Json;

function TestMethod($input, $output)
{
    $result = Json::canonicalize($input);

    expect($result)->toEqual($output);
}

it('can canonicalize arrays', fn($input, $output) => TestMethod($input, $output))
->with('input.arrays')
->with('output.arrays');


it('can canonicalize structures', fn($input, $output) => TestMethod($input, $output))
    ->with('input.structures')
    ->with('output.structures');

it('can canonicalize french', fn($input, $output) => TestMethod($input, $output))
    ->with('input.french')
    ->with('output.french');

it('can canonicalize unicode', fn($input, $output) => TestMethod($input, $output))
    ->with('input.unicode')
    ->with('output.unicode');

it('can canonicalize values', fn($input, $output) => TestMethod($input, $output))
    ->with('input.values')
    ->with('output.values');

it('can canonicalize weird', fn($input, $output) => TestMethod($input, $output))
    ->with('input.weird')
    ->with('output.weird');