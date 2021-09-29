<?php

namespace JackSleight\BardMutator\Support\Traits;

use JackSleight\BardMutator\Facades\Mutator;

trait MutatesMark
{
    public function mutateTag($tag)
    {
        return Mutator::mutateTag($this->markType, $this->mark, $tag);
    }

    public function tag()
    {
        return $this->mutateTag(parent::tag());
    }
}
