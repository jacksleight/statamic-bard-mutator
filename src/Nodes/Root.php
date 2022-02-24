<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class Root extends \ProseMirrorToHtml\Nodes\Node
{
    protected $nodeType = 'bmu_root';

    public function matching()
    {
        if ($this->node->type !== $this->nodeType) {
            return false;
        }

        Mutator::processRoot($this->node);

        return true;
    }
}
