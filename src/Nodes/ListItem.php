<?php

namespace JackSleight\BardMutator\Nodes;

use JackSleight\BardMutator\Support\Traits\MutatesNode;

class ListItem extends \ProseMirrorToHtml\Nodes\ListItem
{
    use MutatesNode;
}
