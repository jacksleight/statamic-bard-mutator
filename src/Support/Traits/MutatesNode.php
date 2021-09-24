<?php

namespace JackSleight\BardMutator\Support\Traits;

use JackSleight\BardMutator\Facades\Mutator;

trait MutatesNode
{
    public function mutateNode($tag)
    {
        return Mutator::mutateNode($this->nodeType, $this->node, $tag);
    }

    public function tag()
    {
        return $this->mutateNode(parent::tag());
    }
}
