<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

uses(Tests\TestCase::class);
beforeEach(function () {
    foreach ($this->nodes as $type => $attrs) {
        Mutator::tag($type, function ($tag) {
            $tag[0]['attrs']['class'] = 'test-tag';

            return $tag;
        });
    }

    foreach ($this->marks as $type => $attrs) {
        Mutator::tag($type, function ($tag) {
            $tag[0]['attrs']['class'] = 'test-tag';

            return $tag;
        });
    }

    Mutator::tag('table', function ($tag) {
        array_unshift($tag, [
            'tag' => 'div',
            'attrs' => ['class' => 'table-wrapper'],
        ]);

        return $tag;
    });

    Mutator::tag('listItem', function ($tag, $data, $meta) {
        if ($meta['parent']->type === 'bulletList') {
            array_push($tag, 'span');
        }

        return $tag;
    });

    Mutator::tag('image', function ($tag) {
        $tag[0]['tag'] = 'fancy-image';

        return $tag;
    });
});


it('mutates all nodes', function () {
    foreach ($this->nodes as $type => $attrs) {
        $value = $this->getTestNode($type, $attrs);
        $this->assertStringContainsString('class="test-tag"', $this->renderTestValue($value));
    }
});

it('mutates all marks', function () {
    foreach ($this->marks as $type => $attrs) {
        $value = $this->getTestMark($type, $attrs);
        $this->assertStringContainsString('class="test-tag"', $this->renderTestValue($value));
    }
});

it('adds a wrapper div around all tables', function () {
    $value = $this->getTestValue([[
        'type' => 'table',
        'content' => [[
            'type' => 'tableRow',
        ]],
    ]]);
    $this->assertStringContainsString('<div class="table-wrapper"><table class="test-tag"><tbody><tr class="test-tag">', $this->renderTestValue($value));
});

test('is adds a wrapper span around all bullet list item content', function () {
    $value = $this->getTestValue([[
        'type' => 'bulletList',
        'content' => [[
            'type' => 'listItem',
        ]],
    ]]);
    $this->assertStringContainsString('<span>', $this->renderTestValue($value));

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
    $this->assertStringContainsString('<fancy-image', $this->renderTestValue($value));
});
