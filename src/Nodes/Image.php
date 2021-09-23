<?php

namespace JackSleight\BardMutator\Nodes;

use JackSleight\BardMutator\Support\Traits\MutatesNode;

class Image extends \Statamic\Fieldtypes\Bard\ImageNode
{
    protected $nodeType = 'image';

    use MutatesNode;
}
