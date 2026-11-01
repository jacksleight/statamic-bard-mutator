<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html('paragraph', function ($value) {
    $value[1]['data-scoped'] = 'test_scoped';

    return $value;
})->scoped(true)->handle('test_scoped')->display('Scoped Test (paragraphs)');

Mutator::html('horizontalRule', function ($value) {
    $value[1]['data-global'] = 'true';

    return $value;
});
