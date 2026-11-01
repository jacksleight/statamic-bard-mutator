<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value) {
    $value[1]['data-saved'] = 'render ran on save';

    return $value;
})->scoped(true)->handle('test_save_html');

Mutator::html('paragraph', null, function ($value) {
    $value[] = ['tag' => 'div[data-scoped]'];

    return $value;
})->scoped(true)->handle('test_save_html');

Mutator::html('blockquote', null, function ($value) {
    $value[] = ['tag' => 'div[data-global]'];

    return $value;
});
