<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::renderHtml('paragraph', function ($value, $data, $meta, $type) {
    $value[1]['data-type'] = $type;
    $value[1]['data-depth'] = $meta['depth'];
    $value[1]['data-parent'] = $meta['parent']->type;
    $value[1]['data-has-bard'] = $meta['bard'] ? 'true' : 'false';

    return $value;
})->scoped(true)->handle('test_deprecated');

Mutator::parseHtml('paragraph', function ($value) {
    return $value;
})->scoped(true)->handle('test_deprecated');

Mutator::data('heading', function ($data, $meta, $type) {
    $data->content[] = Data::text(" ({$type}, index {$meta['index']})");
})->scoped(true)->handle('test_deprecated');
