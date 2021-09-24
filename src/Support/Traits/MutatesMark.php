<?php

namespace JackSleight\BardMutator\Support\Traits;

use JackSleight\BardMutator\Facades\Mutator;

trait MutatesMark
{
    public function mutateMark($tag)
    {
        return Mutator::mutateMark($this->markType, $this->mark, $tag);
    }

    public function tag()
    {
        return $this->mutateMark(parent::tag());
    }
}
