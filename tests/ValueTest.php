<?php

use JackSleight\StatamicBardMutator\Support\Value;

uses(Tests\TestCase::class);

it('converts tag to html', function () {
    $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];
    $html = ['a', ['href' => 'http://example.com'], 0];

    expect(Value::tagToHtml($tag))->toEqual($html);
});

it('converts html to tag', function () {
    $html = ['a', ['href' => 'http://example.com'], 0];
    $tag = [['tag' => 'a', 'attrs' => ['href' => 'http://example.com']]];

    expect(Value::htmlToTag($html))->toEqual($tag);
});

it('converts nested tag to html', function () {
    $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];
    $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];

    expect(Value::tagToHtml($tag))->toEqual($html);
});

it('converts nested html to tag', function () {
    $html = ['div', [], ['table', [], 0], ['tbody', [], 0]];
    $tag = [['tag' => 'div', 'attrs' => []], ['tag' => 'table', 'attrs' => []], ['tag' => 'tbody', 'attrs' => []]];

    expect(Value::htmlToTag($html))->toEqual($tag);
});
