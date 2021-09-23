<?php

namespace JackSleight\BardMutator\Support\Traits;

use JackSleight\BardMutator\Facades\Mutator;

trait MutatesNode
{
    public function tag()
    {
        return Mutator::mutateNode($this->nodeType, $this->node, parent::tag());
    }
}
