<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('types plugins to the correct fields', function () {
    $paragraph = Mutator::data('paragraph', fn ($data) => null);
    $heading = Mutator::data('heading', fn ($data) => null);

    $field = $this->getTestField();

    $plugins1 = Mutator::filteredPlugins($field, 'paragraph');
    $plugins2 = Mutator::filteredPlugins($field, 'heading');

    expect($plugins1)
        ->toHaveCount(1)
        ->toContain($paragraph);
    expect($plugins2)
        ->toHaveCount(1)
        ->toContain($heading);
});
