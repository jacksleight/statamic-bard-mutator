<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Support\Traits\MutatesNode;

class OrderedList extends \ProseMirrorToHtml\Nodes\OrderedList
{
    use MutatesNode;
}
