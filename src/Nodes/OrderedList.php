<?php

namespace JackSleight\BardMutator\Nodes;

use JackSleight\BardMutator\Support\Traits\MutatesNode;

class OrderedList extends \ProseMirrorToHtml\Nodes\OrderedList
{
    use MutatesNode;
}
