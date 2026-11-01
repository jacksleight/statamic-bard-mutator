<?php

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('heading', function ($item) {
    $text = collect($item->content)->implode('text');
    $slug = Str::slug($text);
    array_unshift($item->content, Data::html(
        '<a id="'.$slug.'" href="#'.$slug.'">#</a>'
    ));
})->scoped(true)->handle('demo_permalinks');
