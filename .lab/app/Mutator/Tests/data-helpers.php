<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Support\Data;

Mutator::data('bmuRoot', function ($item) {
    $content = [];
    foreach ($item->content as $node) {
        $marker = $node->type === 'paragraph' ? ($node->content[0]->text ?? null) : null;
        $content[] = $node;
        match ($marker) {
            'node' => $content[] = Data::node('heading', ['level' => 3], [Data::text('Heading built with Data::node')]),
            'mark' => $node->content[0]->marks[] = Data::mark('link', ['href' => 'https://example.com/data-mark']),
            'text' => $node->content[] = Data::text(' and text added with Data::text', [Data::mark('italic')]),
            'html tag' => $content[] = Data::html('aside', ['class' => 'tag-mode'], [Data::text('Data::html tag mode with content')]),
            'html raw' => $content[] = Data::html('<aside class="raw-mode">Data::html raw mode</aside>'),
            'html raw second arg' => $node->content[] = Data::html(' <span class="raw-marks">raw with marks</span>', [Data::mark('bold')]),
            'apply' => Data::apply($node, type: 'heading', attrs: ['level' => 4]),
            'clone' => $content[] = Data::clone($node, content: [Data::text('Cloned with Data::clone')]),
            'morph' => Data::morph($node, Data::node('blockquote', null, [Data::node('paragraph', null, [Data::text('Morphed into a blockquote with Data::morph')])])),
            default => null,
        };
    }
    $item->content = $content;
    $count = 0;
    Data::walk($item, function () use (&$count) {
        $count++;
    });
    $item->content[] = Data::node('paragraph', null, [Data::text("Data::walk visited {$count} items")]);
})->scoped(true)->handle('test_data_helpers');
