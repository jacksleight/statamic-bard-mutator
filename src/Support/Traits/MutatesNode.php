<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesNode
{
    public function renderHTML($node, $HTMLAttributes = [])
    {
        return Mutator::mutateHtmlCompat($node, parent::renderHTML($node, $HTMLAttributes));
    }
}
