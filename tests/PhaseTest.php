<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);

it('calls mutator once per node', function () {
    $calls = 0;
    Mutator::html('paragraph', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([[
        'type' => 'paragraph',
    ]]);
    expect($this->renderTestValue($value))->toEqual('<p></p>');
    expect($calls)->toEqual(1);
});

it('calls mutator once per mark', function () {
    $calls = 0;
    Mutator::html('bold', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([[
        'type' => 'text',
        'text' => 'Some text',
        'marks' => [
            [
                'type' => 'bold',
            ],
        ],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<strong>Some text</strong>');
    expect($calls)->toEqual(1);
});

it('calls mutator once per adjacent marks', function () {
    $calls = 0;
    Mutator::html('bold', function ($value) use (&$calls) {
        $calls++;

        return $value;
    });

    $value = $this->getTestValue([
        [
            'type' => 'text',
            'text' => 'Some text',
            'marks' => [
                [
                    'type' => 'bold',
                ],
            ],
        ],
        [
            'type' => 'text',
            'text' => ' and some more text',
            'marks' => [
                [
                    'type' => 'bold',
                ],
            ],
        ],
    ]);
    expect($this->renderTestValue($value))->toEqual('<strong>Some text and some more text</strong>');
    expect($calls)->toEqual(1);
});

it('fetches adjacent marks mutated value', function () {
    Mutator::html('link', function ($value) {
        $value[0] = 'fancy-link';

        return $value;
    });

    $value = $this->getTestValue([
        [
            'type' => 'text',
            'text' => 'Some text',
            'marks' => [
                [
                    'type' => 'link',
                    'attrs' => [
                        'href' => 'http://example.com/',
                    ],
                ],
            ],
        ],
        [
            'type' => 'text',
            'text' => ' and some more text',
            'marks' => [
                [
                    'type' => 'link',
                    'attrs' => [
                        'href' => 'http://example.com/',
                    ],
                ],
            ],
        ],
    ]);
    expect($this->renderTestValue($value))->toEqual('<fancy-link href="http://example.com/">Some text and some more text</fancy-link>');
});
