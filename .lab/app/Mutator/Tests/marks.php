<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('bold', function ($value) {
    return ['strong', ['class' => 'b'], ['span', ['class' => 'b-inner'], 0]];
})->scoped(true)->handle('test_marks');

Mutator::html(['italic', 'code'], function ($value, $type) {
    $value[1]['class'] = $type;

    return $value;
})->scoped(true)->handle('test_marks');

Mutator::html('link', function ($value) {
    $value[1]['class'] = 'link';

    return $value;
})->scoped(true)->handle('test_marks');
