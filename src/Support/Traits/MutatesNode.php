<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesNode
{
    public function mutateNode($tag)
    {
        return Mutator::mutateTag('node', $this->nodeType, $this->node, $tag);
    }

    public function tag()
    {
        return $this->mutateNode(parent::tag());
    }
}
