<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Support\Value;

class ValueTest extends TestCase
{
    /** @test */
    public function it_converts_tag_to_html()
    {
        $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];
        $html = ['a', ['href' => 'http://example.com'], 0];

        $this->assertEquals($html, Value::tagToHtml($tag));
    }

    /** @test */
    public function it_converts_html_to_tag()
    {
        $html = ['a', ['href' => 'http://example.com'], 0];
        $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];

        $this->assertEquals($tag, Value::htmlToTag($html));
    }

    /** @test */
    public function it_converts_nested_tag_to_html()
    {
        $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];
        $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];

        $this->assertEquals($html, Value::tagToHtml($tag));
    }

    /** @test */
    public function it_converts_nested_html_to_tag()
    {
        $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];
        $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];

        $this->assertEquals($tag, Value::htmlToTag($html));
    }
}
