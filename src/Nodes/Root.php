<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class Root extends \Tiptap\Core\Node
{
    protected $nodeType = 'bmu_root';

    public function tag()
    {
        Mutator::processRoot($this->node);

        return null;
    }
}
