<?php

use JackSleight\StatamicBardMutator\Support\Data;

uses(Tests\TestCase::class);

it('creates node object', function () {
    $node = Data::node('paragraph');

    $this->assertEquals('paragraph', $node->type);
});

it('creates node object with attributes', function () {
    $node = Data::node('image', ['src' => 'https://example.com/image.jpg']);

    $this->assertEquals('image', $node->type);
    $this->assertEquals('https://example.com/image.jpg', $node->attrs->src);
});

it('creates mark object', function () {
    $mark = Data::mark('bold');

    $this->assertEquals('bold', $mark->type);
});

it('creates mark object with attributes', function () {
    $mark = Data::mark('link', ['href' => 'https://example.com']);

    $this->assertEquals('link', $mark->type);
    $this->assertEquals('https://example.com', $mark->attrs->href);
});

it('creates text node object', function () {
    $node = Data::text('Hello world');

    $this->assertEquals('text', $node->type);
    $this->assertEquals('Hello world', $node->text);
});

it('creates html node object', function () {
    $node = Data::html('<p>Hello world</p>');

    $this->assertEquals('bmuHtml', $node->type);
    $this->assertEquals('<p>Hello world</p>', $node->html);
});
