<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class TagMutatorTest extends TestCase
{
    protected $nodes = [
        'blockquote'      => [],
        'bullet_list'     => [],
        'code_block'      => [],
        'hard_break'      => [],
        'heading'         => ['level' => 1],
        'horizontal_rule' => [],
        'image'           => ['src' => 'test.jpg'],
        'list_item'       => [],
        'ordered_list'    => [],
        'paragraph'       => [],
        'table_cell'      => [],
        'table_header'    => [],
        'table_row'       => [],
        'table'           => [],
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
            Mutator::tag($type, function ($tag) {
                $tag[0]['attrs']['class'] = 'my-class';

                return $tag;
            });
        }
        foreach ($this->marks as $type => $attrs) {
            Mutator::tag($type, function ($tag) {
                $tag[0]['attrs']['class'] = 'my-class';

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

        Mutator::tag('list_item', function ($tag, $data, $meta) {
            if ($meta['parent']->type === 'bullet_list') {
                array_push($tag, 'span');
            }

            return $tag;
        });

        Mutator::tag('image', function ($tag) {
            $tag[0]['tag'] = 'fancy-image';

            return $tag;
        });

        Mutator::data('list_item', function ($data) {
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
            $this->assertStringContainsString('class="my-class"', Mutator::render($value));
        }
    }

    /** @test */
    public function it_mutates_all_marks()
    {
        foreach ($this->marks as $type => $attrs) {
            $value = $this->getTestMark($type, $attrs);
            $this->assertStringContainsString('class="my-class"', Mutator::render($value));
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
            'type' => 'bullet_list',
            'content' => [[
                'type' => 'list_item',
            ]],
        ]]);
        $this->assertStringContainsString('<span>', Mutator::render($value));

        $value = $this->getTestValue([[
            'type'    => 'ordered_list',
            'content' => [[
                'type' => 'list_item',
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
        $this->assertStringContainsString('<fancy-image ', Mutator::render($value));
    }

    /** @test */
    public function it_removes_paragraph_nodes_inside_list_items()
    {
        $value = $this->getTestValue([[
            'type'    => 'list_item',
            'content' => [[
                'type'    => 'paragraph',
                'content' => [],
            ]],
        ]]);
        $this->assertStringNotContainsString('<p ', Mutator::render($value));
    }
}
