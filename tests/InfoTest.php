<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Info;

uses(Tests\TestCase::class);

it('is passed info object', function () {
    Mutator::data('text', function ($item, $info) {
        expect($info)->toBeInstanceOf(Info::class);
        expect($info->item)->toBeInstanceOf(stdClass::class);
        expect($info->item)->toBe($item);
    });
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [
            [
                'type' => 'listItem',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'A',
                    ],
                ],
            ],
        ],
    ]]);
    $this->renderTestValue($value);
});

it('can traverse info objects', function () {
    Mutator::data('text', function ($item, $info) {
        if ($item->text !== 'B') {
            return;
        }

        expect($info->parent)->toBeInstanceOf(Info::class);
        expect($info->parent->item)->toBeInstanceOf(stdClass::class);
        expect($info->parent->type)->toEqual('listItem');

        expect($info->parent->parent)->toBeInstanceOf(Info::class);
        expect($info->parent->parent->item)->toBeInstanceOf(stdClass::class);
        expect($info->parent->parent->type)->toEqual('bulletList');

        expect($info->prev)->toBeInstanceOf(Info::class);
        expect($info->prev->item)->toBeInstanceOf(stdClass::class);
        expect($info->prev->type)->toEqual('text');
        expect($info->prev->text)->toEqual('A');

        expect($info->next)->toBeInstanceOf(Info::class);
        expect($info->next->item)->toBeInstanceOf(stdClass::class);
        expect($info->next->type)->toEqual('text');
        expect($info->next->text)->toEqual('C');
    });
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [
            [
                'type' => 'listItem',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'A',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'B',
                    ],
                    [
                        'type' => 'text',
                        'text' => 'C',
                    ],
                ],
            ],
        ],
    ]]);
    $this->renderTestValue($value);
});
