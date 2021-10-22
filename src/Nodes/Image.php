<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Support\Traits\MutatesNode;

class Image extends \Statamic\Fieldtypes\Bard\ImageNode
{
    // \Statamic\Fieldtypes\Bard\ImageNode is missing this
    protected $nodeType = 'image';

    use MutatesNode;
}
