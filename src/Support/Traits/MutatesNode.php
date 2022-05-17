<?php

namespace JackSleight\StatamicBardMutator\Support\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

trait MutatesNode
{
    public function mutateNode($tag, $node)
    {
        return Mutator::mutateTag($node->type, $node, $tag);
    }

    public function renderHTML($node, $HTMLAttributes = [])
    {
        return $this->mutateNode(parent::renderHTML($node, $HTMLAttributes), $node);
    }
}
