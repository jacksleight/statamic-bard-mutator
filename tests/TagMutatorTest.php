<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class TagMutatorTest extends TestCase
{
    protected $nodes = [
        'blockquote' => [],
        'bulletList' => [],
        'codeBlock' => [],
        'hardBreak' => [],
        'heading' => ['level' => 1],
        'horizontalRule' => [],
        'image' => ['src' => 'test.jpg'],
        'listItem' => [],
        'orderedList' => [],
        'paragraph' => [],
        'tableCell' => [],
        'tableHeader' => [],
        'tableRow' => [],
        'table' => [],
    ];

    protected $marks = [
        'bold' => [],
        'code' => [],
        'italic' => [],
        'link' => ['href' => '#'],
        'small' => [],
        'strike' => [],
        'subscript' => [],
        'superscript' => [],
        'underline' => [],
    ];

    public function setUp(): void
    {
        parent::setUp();

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
    }

    /** @test */
    public function it_mutates_all_nodes()
    {
        foreach ($this->nodes as $type => $attrs) {
            $value = $this->getTestNode($type, $attrs);
            $this->assertStringContainsString('class="test-tag"', $this->renderTestValue($value));
        }
    }

    /** @test */
    public function it_mutates_all_marks()
    {
        foreach ($this->marks as $type => $attrs) {
            $value = $this->getTestMark($type, $attrs);
            $this->assertStringContainsString('class="test-tag"', $this->renderTestValue($value));
        }
    }

    /** @test */
    public function it_adds_a_wrapper_div_around_all_tables()
    {
        $value = $this->getTestValue([[
            'type' => 'table',
        ]]);
        $this->assertStringContainsString('<div class="table-wrapper">', $this->renderTestValue($value));
    }

    /** @test */
    public function is_adds_a_wrapper_span_around_all_bullet_list_item_content()
    {
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
    }

    /** @test */
    public function it_converts_all_images_to_a_custom_element()
    {
        $value = $this->getTestValue([[
            'type' => 'image',
            'attrs' => [
                'src' => 'image.jpg',
            ],
        ]]);
        $this->assertStringContainsString('<fancy-image', $this->renderTestValue($value));
    }
}
