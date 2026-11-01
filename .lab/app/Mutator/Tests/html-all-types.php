<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;

Mutator::html([
    'blockquote', 'bulletList', 'codeBlock', 'hardBreak', 'heading', 'horizontalRule', 'image', 'listItem',
    'orderedList', 'paragraph', 'table', 'tableCell', 'tableHeader', 'tableRow',
    'bold', 'code', 'italic', 'link', 'small', 'strike', 'subscript', 'superscript', 'underline',
], function ($value, $type) {
    $value[1]['data-bmu'] = $type;

    return $value;
})->scoped(true)->handle('test_html_all_types');
