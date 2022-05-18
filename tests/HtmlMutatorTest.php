<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class HtmlMutatorTest extends TestCase
{
    protected $nodes = [
        'blockquote'     => [],
        'bulletList'     => [],
        'codeBlock'      => [],
        'hardBreak'      => [],
        'heading'        => ['level' => 1],
        'horizontalRule' => [],
        'image'          => ['src' => 'test.jpg'],
        'listItem'       => [],
        'orderedList'    => [],
        'paragraph'      => [],
        'tableCell'      => [],
        'tableHeader'    => [],
        'tableRow'       => [],
        'table'          => [],
    ];

    protected $marks = [
        'bold'        => [],
        'code'        => [],
        'italic'      => [],
        'link'        => ['href' => '#'],
        'small'       => [],
        'strike'      => [],
        'subscript'   => [],
        'superscript' => [],
        'underline'   => [],
    ];

    public function setUp(): void
    {
        parent::setUp();

        foreach ($this->nodes as $type => $attrs) {
            Mutator::html($type, function ($html) {
                $html[1]['class'] = 'test-html';

                return $html;
            });
        }
        foreach ($this->marks as $type => $attrs) {
            Mutator::html($type, function ($html) {
                $html[1]['class'] = 'test-html';

                return $html;
            });
        }

        Mutator::html('table', function ($html) {
            $html = ['div', ['class' => 'table-wrapper'], $html];

            return $html;
        });

        Mutator::html('listItem', function ($html, $data, $meta) {
            if ($meta['parent']->type === 'bulletList') {
                $html[2] = ['span', [], 0];
            }

            return $html;
        });

        Mutator::html('image', function ($html) {
            $html[0] = 'fancy-image';

            return $html;
        });

        Mutator::data('listItem', function ($data) {
            if (($data->content[0]->type ?? null) === 'paragraph') {
                $data->content = $data->content[0]->content;
            }
        });
    }

    /** @test */
    public function it_mutates_all_nodes()
    {
        foreach ($this->nodes as $type => $attrs) {
            $value = $this->getTestNode($type, $attrs);
            $this->assertStringContainsString('class="test-html"', Mutator::render($value));
        }
    }

    /** @test */
    public function it_mutates_all_marks()
    {
        foreach ($this->marks as $type => $attrs) {
            $value = $this->getTestMark($type, $attrs);
            $this->assertStringContainsString('class="test-html"', Mutator::render($value));
        }
    }

    /** @test */
    public function it_adds_a_wrapper_div_around_all_tables()
    {
        $value = $this->getTestValue([[
            'type' => 'table',
        ]]);
        $this->assertStringContainsString('<div class="table-wrapper">', Mutator::render($value));
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
        $this->assertStringContainsString('<span>', Mutator::render($value));

        $value = $this->getTestValue([[
            'type'    => 'orderedList',
            'content' => [[
                'type' => 'listItem',
            ]],
        ]]);
        $this->assertStringNotContainsString('<span>', Mutator::render($value));
    }

    /** @test */
    public function it_converts_all_images_to_a_custom_element()
    {
        $value = $this->getTestValue([[
            'type'  => 'image',
            'attrs' => [
                'src' => 'image.jpg',
            ],
        ]]);
        $this->assertStringContainsString('<fancy-image', Mutator::render($value));
    }

    /** @test */
    public function it_removes_paragraph_nodes_inside_list_items()
    {
        $value = $this->getTestValue([[
            'type'    => 'listItem',
            'content' => [[
                'type'    => 'paragraph',
                'content' => [],
            ]],
        ]]);
        $this->assertStringContainsString('<li', Mutator::render($value));
        $this->assertStringNotContainsString('<p', Mutator::render($value));
    }
}
