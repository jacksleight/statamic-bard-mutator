<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('scopes plugins to the correct fields', function () {
    $foo = Mutator::data('paragraph', fn ($data) => null)->scoped(true)->handle('foo');
    $bar = Mutator::data('paragraph', fn ($data) => null)->scoped(true)->handle('bar');
    $baz = Mutator::data('paragraph', fn ($data) => null)->scoped(true)->handle('baz');
    $non = Mutator::data('paragraph', fn ($data) => null);

    $field1 = $this->getTestField([
        'bmu_plugins' => [
            'foo',
            'bar',
        ],
    ]);

    $field2 = $this->getTestField([
        'bmu_plugins' => [
            'foo',
            'baz',
        ],
    ]);

    $plugins1 = Mutator::filteredPlugins($field1, 'paragraph');
    $plugins2 = Mutator::filteredPlugins($field2, 'paragraph');

    expect($plugins1)
        ->toHaveCount(3)
        ->toContain($foo, $bar, $non);
    expect($plugins2)
        ->toHaveCount(3)
        ->toContain($foo, $baz, $non);
});
