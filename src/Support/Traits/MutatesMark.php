<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesMark
{
    public function renderHTML($mark, $HTMLAttributes = [])
    {
        return Mutator::mutateHtmlCompat($mark, parent::renderHTML($mark, $HTMLAttributes));
    }
}
