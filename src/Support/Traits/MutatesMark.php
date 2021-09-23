<?php

namespace JackSleight\BardMutator\Support\Traits;

use JackSleight\BardMutator\Facades\Mutator;

trait MutatesMark
{
    public function tag()
    {
        return Mutator::mutateMark($this->markType, $this->mark, parent::tag());
    }
}
