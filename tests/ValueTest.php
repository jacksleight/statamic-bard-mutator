<?php

use JackSleight\StatamicBardMutator\Support\Value;

uses(Tests\TestCase::class);

it('converts tag to html', function () {
    $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];
    $html = ['a', ['href' => 'http://example.com'], 0];

    $this->assertEquals($html, Value::tagToHtml($tag));
});

it('converts html to tag', function () {
    $html = ['a', ['href' => 'http://example.com'], 0];
    $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];

    $this->assertEquals($tag, Value::htmlToTag($html));
});

it('converts nested tag to html', function () {
    $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];
    $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];

    $this->assertEquals($html, Value::tagToHtml($tag));
});

it('converts nested html to tag', function () {
    $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];
    $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];

    $this->assertEquals($tag, Value::htmlToTag($html));
});
