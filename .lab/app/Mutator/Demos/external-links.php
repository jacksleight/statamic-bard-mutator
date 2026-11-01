<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Facades\URL;

Mutator::html('link', function ($value) {
    if (URL::isExternal($value[1]['href'])) {
        $value[1]['class'] = 'external';
    }
    return $value;
})->scoped(true)->handle('demo_external_links');
