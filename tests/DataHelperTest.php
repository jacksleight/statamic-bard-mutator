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
    $node1 = Data::html('<p>Hello world</p>');
    $node2 = Data::html('p');
    $node3 = Data::html('p', [], $content = [Data::text('Hello world')]);

    expect($node1->type)->toEqual('bmuHtml');
    expect($node1->render)->toEqual(['content' => '<p>Hello world</p>']);

    expect($node2->type)->toEqual('bmuHtml');
    expect($node2->render)->toEqual(['p', [], 0]);

    expect($node3->type)->toEqual('bmuHtml');
    expect($node3->render)->toEqual(['p', [], 0]);
    expect($node3->content)->toEqual($content);
});

it('applys node', function () {
    $node1 = Data::node('p', ['foo' => 1]);
    $node2 = Data::apply($node1, attrs: ['bar' => 2]);

    expect($node2->attrs)->toEqual((object) ['bar' => 2]);
});

it('clones node', function () {
    $node1 = Data::node('p', ['foo' => 1]);
    $node2 = Data::clone($node1, attrs: ['bar' => 2]);

    expect($node2)->not()->toBe($node1);
    expect($node2->attrs)->toEqual((object) ['bar' => 2]);
});

it('morphs node', function () {
    $node = Data::node('p', ['foo' => 1], [Data::text('Hello world')]);
    Data::morph($node, Data::node('heading', attrs: ['bar' => 2]));

    expect($node->type)->toEqual('heading');
    expect($node->attrs)->toEqual((object) ['bar' => 2]);
    expect($node->content)->toEqual([]);
});
