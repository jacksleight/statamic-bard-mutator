<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html(['code_block', 'unordered_list', 'ordered_list', 'list_item'], function ($value, $type) {
    $value[1]['data-alias'] = $type;

    return $value;
})->scoped(true)->handle('test_aliases');
