<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('image', function ($value) {
    return ['content' => view('partials/image', $value[1])];
})->scoped(true)->handle('test_images');
