<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Plugins\RemoveInnerParagraphs;

uses(Tests\TestCase::class);

it('removes inner paragraphs', function () {
    Mutator::plugin(new RemoveInnerParagraphs);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li>Test</li>');
});

it('removes sole inner paragraphs only', function () {
    Mutator::plugin(new RemoveInnerParagraphs);
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'heading',
            'attrs' => [
                'level' => 1,
            ],
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ], [
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Test',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<li><h1>Test</h1><p>Test</p></li>');
});
