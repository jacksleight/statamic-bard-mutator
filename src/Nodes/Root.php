<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class Root extends \Tiptap\Core\Node
{
    public static $name = 'bmuRoot';

    public function renderHTML($node, $HTMLAttributes = [])
    {
        Mutator::processRoot($node);

        return null;
    }
}
