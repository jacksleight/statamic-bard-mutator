<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesExtension
{
    public function parseHTML()
    {
        return Mutator::mutate('parseHtml', static::$name, parent::parseHTML());
    }

    public function renderHTML($data, $HTMLAttributes = [])
    {
        return Mutator::mutate('renderHtml', static::$name, parent::renderHTML($data, $HTMLAttributes), [
            'data'           => $data,
            'htmlAttributes' => $HTMLAttributes,
        ]);
    }
}
