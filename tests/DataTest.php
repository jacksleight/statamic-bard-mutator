<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Support\Data;

class DataTest extends TestCase
{
    /** @test */
    public function it_creates_node_object()
    {
        $node = Data::node('paragraph');

        $this->assertEquals('paragraph', $node->type);
    }

    /** @test */
    public function it_creates_node_object_with_attributes()
    {
        $node = Data::node('image', ['src' => 'https://example.com/image.jpg']);

        $this->assertEquals('image', $node->type);
        $this->assertEquals('https://example.com/image.jpg', $node->attrs->src);
    }

    /** @test */
    public function it_creates_mark_object()
    {
        $mark = Data::mark('bold');

        $this->assertEquals('bold', $mark->type);
    }

    /** @test */
    public function it_creates_mark_object_with_attributes()
    {
        $mark = Data::mark('link', ['href' => 'https://example.com']);

        $this->assertEquals('link', $mark->type);
        $this->assertEquals('https://example.com', $mark->attrs->href);
    }

    /** @test */
    public function it_creates_text_node_object()
    {
        $node = Data::text('Hello world');

        $this->assertEquals('text', $node->type);
        $this->assertEquals('Hello world', $node->text);
    }

    /** @test */
    public function it_creates_html_node_object()
    {
        $node = Data::html('<p>Hello world</p>');

        $this->assertEquals('bmuHtml', $node->type);
        $this->assertEquals('<p>Hello world</p>', $node->html);
    }
}
