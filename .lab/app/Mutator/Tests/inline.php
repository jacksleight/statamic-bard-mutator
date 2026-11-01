<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['bold', 'link'], function ($value, $type) {
    $value[1]['data-inline'] = $type;

    return $value;
})->scoped(true)->handle('test_inline');

Mutator::html('paragraph', function ($value) {
    $value[1]['data-inline'] = 'paragraph';

    return $value;
})->scoped(true)->handle('test_inline');
