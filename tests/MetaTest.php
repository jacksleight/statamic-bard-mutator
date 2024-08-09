<?php

// @deprecated 3.0.0

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('is passed meta data array', function () {
    Mutator::html('listItem', function ($value, $meta) {
        expect($meta)
            ->toBeArray()
            ->toHaveKeys([
                'parent',
                'prev',
                'next',
                'index',
                'depth',
                'root',
                'bard',
            ]);

        return $value;
    });
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    $this->renderTestValue($value);
});
