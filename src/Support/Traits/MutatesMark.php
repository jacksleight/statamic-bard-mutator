<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesMark
{
    public function mutateTag($tag)
    {
        return Mutator::mutateTag('mark', $this->markType, $this->mark, $tag);
    }

    public function tag()
    {
        return $this->mutateTag(parent::tag());
    }
}
