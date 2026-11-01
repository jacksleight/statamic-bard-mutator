<?php

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::html('link', function ($value, $item) {
    $href = $item->attrs->href ?? '';
    $value[1]['data-kind'] = match (true) {
        Str::startsWith($href, 'mailto:') => 'mailto',
        URL::isExternal($value[1]['href']) => 'external',
        default => 'internal',
    };
    $value[1]['data-is-external'] = URL::isExternal($value[1]['href']) ? 'true' : 'false';

    return $value;
})->scoped(true)->handle('test_links');
