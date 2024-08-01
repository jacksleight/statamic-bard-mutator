<?php

use JackSleight\StatamicBardMutator\Support\Data;

uses(Tests\TestCase::class);

it('creates node object', function () {
    $node = Data::node('paragraph');

    expect($node->type)->toEqual('paragraph');
});

it('creates node object with attributes', function () {
    $node = Data::node('image', ['src' => 'https://example.com/image.jpg']);

    expect($node->type)->toEqual('image');
    expect($node->attrs->src)->toEqual('https://example.com/image.jpg');
});

it('creates mark object', function () {
    $mark = Data::mark('bold');

    expect($mark->type)->toEqual('bold');
});

it('creates mark object with attributes', function () {
    $mark = Data::mark('link', ['href' => 'https://example.com']);

    expect($mark->type)->toEqual('link');
    expect($mark->attrs->href)->toEqual('https://example.com');
});

it('creates text node object', function () {
    $node = Data::text('Hello world');

    expect($node->type)->toEqual('text');
    expect($node->text)->toEqual('Hello world');
});

it('creates html node object', function () {
    $node = Data::html('<p>Hello world</p>');

    expect($node->type)->toEqual('bmuHtml');
    expect($node->html)->toEqual('<p>Hello world</p>');
});

it('creates html node object advanced', function () {
    $node = Data::html('p', [], $content = [Data::text('Hello world')]);

    expect($node->type)->toEqual('bmuHtml');
    expect($node->html)->toEqual(['p', [], 0]);
    expect($node->content)->toEqual($content);
});

it('morphs node', function () {
    $node = Data::node('p', ['foo' => 1], [Data::text('Hello world')]);
    Data::morph($node, Data::node('heading', attrs: ['bar' => 2]));

    expect($node->type)->toEqual('heading');
    expect($node->attrs)->toEqual((object) ['bar' => 2]);
    expect($node->content)->toEqual([]);
});

it('clones node', function () {
    $node = Data::node('p', ['foo' => 1], [Data::text('Hello world')]);
    $clone = Data::clone($node, attrs: ['bar' => 2]);

    expect($clone)->not()->toBe($node);
    expect($clone->content[0])->not()->toBe($node->content[0]);
    expect($clone->attrs)->toEqual((object) ['bar' => 2]);
});
