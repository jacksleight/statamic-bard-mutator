<?php

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\Plugins\RemoveOuterParagraphs;

uses(Tests\TestCase::class);

// it('removes outer paragraphs', function () {
//     Mutator::plugin(RemoveOuterParagraphs::class);
//     $value = $this->getTestValue([[
//         'type' => 'paragraph',
//         'content' => [[
//             'type' => 'image',
//             'attrs' => [
//                 'src' => '/image.jpg',
//             ],
//         ]],
//     ]]);
//     expect($this->renderTestValue($value))->toEqual('<img src="/image.jpg">');
// });
