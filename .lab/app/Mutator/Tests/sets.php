<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('set', function ($item, $info) {
    $item->attrs->values->text = 'Changed by the set data plugin';
    $parent = $info->parent->item;
    $index = array_search($item, $parent->content, true);
    array_splice($parent->content, $index, 0, [
        Data::node('paragraph', null, [Data::text('Inserted before set '.$item->attrs->values->kind.' by the set data plugin')]),
    ]);
})->scoped(true)->handle('test_sets');
