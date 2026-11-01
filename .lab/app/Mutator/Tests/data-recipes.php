<?php

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Statamic;

Mutator::data('heading', function ($item) {
    $slug = Str::slug(collect($item->content)->implode('text', ''));
    array_unshift(
        $item->content,
        Data::html('<a id="'.$slug.'" href="#'.$slug.'">#</a>')
    );
})->scoped(true)->handle('test_data_recipes');

Mutator::data('blockquote', function ($data) {
    Data::morph($data, Data::html('figure', ['class' => 'quote'], [
        Data::clone($data, content: collect($data->content)->slice(0, -1)->values()->all()),
        Data::html('figcaption', [], [collect($data->content)->last()]),
    ]));
})->scoped(true)->handle('test_data_recipes');

Mutator::data('link', function ($info) {
    $node = $info->parent->item;
    Data::morph($node, Data::html('<svg></svg> '.e($node->text), $node->marks));
})->scoped(true)->handle('test_data_recipes');

Mutator::data('link', function ($item, $info) {
    if (! Str::startsWith($item->attrs->href, 'mailto:')) {
        return;
    }
    $node = $info->parent->item;
    $href = Statamic::modify($item->attrs->href)->obfuscateEmail();
    $marks = collect($node->marks)->reject(fn ($mark) => $mark === $item)->values()->all();
    Data::morph($node, Data::html('<a href="'.$href.'">'.e($node->text).'</a>', $marks));
})->scoped(true)->handle('test_data_recipes_email');
