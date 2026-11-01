<?php

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;
use Statamic\Statamic;

Mutator::html(['bulletList', 'orderedList'], function ($value) {
    $value[1]['class'] = 'list';
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('link', function ($value) {
    if (URL::isExternal($value[1]['href'])) {
        $value[1]['class'] = 'external';
    }
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('heading', function ($value, $item) {
    if ($item->attrs->level === 2) {
        $value[1]['id'] = Str::slug(collect($item->content ?? [])->implode('text', ''));
    }
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('table', function ($value) {
    $inner = array_splice($value, 2, count($value), [0]);
    $value = ['div', ['class' => 'table-wrapper'], $value, ...$inner];
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('listItem', function ($value, $info) {
    if ($info->parent->type === 'bulletList') {
        $value[2] = ['span', [], 0];
    }
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('image', function ($value) {
    $value[0] = 'fancy-image';
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('paragraph', function ($value, $info) {
    if (($info->parent->type ?? null) === 'listItem') {
        return null;
    }
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('paragraph', function ($value, $item) {
    if (($item->content[0]->type ?? null) === 'image') {
        return null;
    }
    return $value;
})->scoped(true)->handle('test_html_recipes_images');

Mutator::html('heading', function ($value, $item) {
    $slug = Str::slug(collect($item->content)->implode('text', ''));
    $value[2] = ['a', [
        'id' => $slug,
        'href' => '#'.$slug,
        'class' => 'hover:underline',
    ], 0];
    return $value;
})->scoped(true)->handle('test_html_recipes');

Mutator::html('link', function ($value, $item) use (&$obfuscated) {
    if (Str::startsWith($item->attrs->href, 'mailto:')) {
        $obfuscated = Statamic::modify(Str::after($item->attrs->href, 'mailto:'))->obfuscateEmail();
        $value[1]['href'] = 'mailto:'.$obfuscated;
    }

    return $value;
})->scoped(true)->handle('test_html_recipes');
