<?php

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('heading', function ($value, $item) {
    $value[1]['id'] = Str::slug(collect($item->content)->implode('text', ''));

    return $value;
})->scoped(true)->handle('test_modifiers');
