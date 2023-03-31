<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);
beforeEach(function () {
    foreach ($this->nodes as $type => $attrs) {
        Mutator::html($type, function ($value) {
            $value[1]['class'] = 'test-html';

            return $value;
        });
    }
    foreach ($this->marks as $type => $attrs) {
        Mutator::html($type, function ($value) {
            $value[1]['class'] = 'test-html';

            return $value;
        });
    }

    Mutator::html('table', function ($value) {
        $inner = array_splice($value, 2, count($value), [0]);
        $value = ['div', ['class' => 'table-wrapper'], $value, ...$inner];

        return $value;
    });

    Mutator::html('listItem', function ($value, $meta) {
        if ($meta['parent']->type === 'bulletList') {
            $value[2] = ['span', [], 0];
        }

        return $value;
    });

    Mutator::html('image', function ($value) {
        $value[0] = 'fancy-image';

        return $value;
    });

    Mutator::data('listItem', function ($data) {
        if (($data->content[0]->type ?? null) === 'paragraph') {
            $data->content = $data->content[0]->content;
        }
    });
});

it('mutates all nodes', function () {
    foreach ($this->nodes as $type => $attrs) {
        $value = $this->getTestNode($type, $attrs);
        expect($this->renderTestValue($value))->toContain('class="test-html"');
    }
});

it('mutates all marks', function () {
    foreach ($this->marks as $type => $attrs) {
        $value = $this->getTestMark($type, $attrs);
        expect($this->renderTestValue($value))->toContain('class="test-html"');
    }
});

it('adds a wrapper div around all tables', function () {
    $value = $this->getTestValue([[
        'type' => 'table',
        'content' => [[
            'type' => 'tableRow',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toContain('<div class="table-wrapper"><table class="test-html"><tbody><tr class="test-html">');
});

test('is adds a wrapper span around all bullet list item content', function () {
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    expect($this->renderTestValue($value))->toContain('<span>');

    $value = $this->getTestValue([[
        'type' => 'orderedList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    $this->assertStringNotContainsString('<span>', $this->renderTestValue($value));
});

it('converts all images to a custom element', function () {
    $value = $this->getTestValue([[
        'type' => 'image',
        'attrs' => [
            'src' => 'image.jpg',
        ],
    ]]);
    expect($this->renderTestValue($value))->toContain('<fancy-image');
});

it('removes paragraph nodes inside list items', function () {
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
