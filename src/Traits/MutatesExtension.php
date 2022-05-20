<?php

namespace JackSleight\StatamicBardMutator\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesExtension
{
    public function parseHTML()
    {
        return Mutator::mutate('parseHTML', static::$name, parent::parseHTML());
    }

    public function renderHTML($data, $HTMLAttributes = [])
    {
        return Mutator::mutate('renderHTML', static::$name, parent::renderHTML($data, $HTMLAttributes), [
            'data'           => $data,
            'HTMLAttributes' => $HTMLAttributes,
        ]);
    }
}
