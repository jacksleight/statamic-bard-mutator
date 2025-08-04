<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

uses(Tests\TestCase::class);

it('converts all hrs to a custom html string', function () {
    Mutator::data('horizontalRule', function ($data) {
        Data::morph($data, Data::html('<custom-hr>'));
    });
    $value = $this->getTestValue([[
        'type' => 'horizontalRule',
    ]]);
    expect($this->renderTestValue($value))->toContain('<custom-hr>');
});

it('removes paragraph nodes inside list items', function () {
    Mutator::data('listItem', function ($data) {
        if (($data->content[0]->type ?? null) === 'paragraph') {
            $data->content = $data->content[0]->content;
        }
    });
    $value = $this->getTestValue([[
        'type' => 'listItem',
        'content' => [[
            'type' => 'paragraph',
            'content' => [],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toContain('<li');
    $this->assertStringNotContainsString('<p', $this->renderTestValue($value));
});

it('converts blockquote to figure and figcaption', function () {
    Mutator::data('blockquote', function ($data) {
        Data::morph($data, Data::html('figure', ['class' => 'quote'], [
            Data::clone($data, content: collect($data->content)->slice(0, -1)->values()->all()),
            Data::html('figcaption', [], [collect($data->content)->last()]),
        ]));
    });
    $value = $this->getTestValue([[
        'type' => 'blockquote',
        'content' => [[
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => 'Lorem ipsum dolor sit amet',
            ]],
        ], [
            'type' => 'paragraph',
            'content' => [[
                'type' => 'text',
                'text' => '— Publius Vergilius Maro',
            ]],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<figure class="quote"><blockquote><p>Lorem ipsum dolor sit amet</p></blockquote><figcaption><p>— Publius Vergilius Maro</p></figcaption></figure>');
});

it('adds svgs to links', function () {
    Mutator::data('link', function ($info) {
        $node = $info->parent->item;
        Data::morph($node, Data::html('<svg></svg> '.e($node->text), $node->marks));
    });
    $value = $this->getTestValue([[
        'type' => 'paragraph',
        'content' => [[
            'type' => 'text',
            'text' => 'Link',
            'marks' => [
                ['type' => 'link', 'attrs' => ['href' => 'https://example.com']],
                ['type' => 'bold'],
            ],
        ]],
    ]]);
    expect($this->renderTestValue($value))->toEqual('<p><a href="https://example.com"><strong><svg></svg> Link</strong></a></p>');
});
