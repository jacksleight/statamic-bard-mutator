<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['heading', 'paragraph', 'bulletList', 'listItem', 'bold', 'italic'], function ($value, $info) {
    $value[1]['data-index'] = (string) $info->index;
    $value[1]['data-depth'] = (string) $info->depth;
    $value[1]['data-parent'] = $info->parent?->type ?? '-';
    $value[1]['data-prev'] = rescue(fn () => $info->prev?->type ?? '-', 'throws', false);
    $value[1]['data-next'] = rescue(fn () => $info->next?->type ?? '-', 'throws', false);
    $value[1]['data-root'] = $info->root->type;
    $value[1]['data-bard'] = $info->bard->handle();

    return $value;
})->scoped(true)->handle('test_info');
