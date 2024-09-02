<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('normalizes snake case types', function () {
    Mutator::html('horizontal_rule', function ($value) {
        $value[1]['class'] = 'rule';

        return $value;
    });
    $value = $this->getTestValue([[
        'type' => 'horizontalRule',
    ]]);
    expect($this->renderTestValue($value))->toEqual('<hr class="rule">');
});

it('normalizes unordered_list type', function () {
    Mutator::html('unordered_list', function ($value) {
        $value[1]['class'] = 'list';

        return $value;
    });
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<ul class="list"><li></li></ul>');
});

it('normalizes unorderedList type', function () {
    Mutator::html('unorderedList', function ($value) {
        $value[1]['class'] = 'list';

        return $value;
    });
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<ul class="list"><li></li></ul>');
});
