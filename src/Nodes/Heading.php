<?php

namespace JackSleight\BardMutator\Nodes;

use JackSleight\BardMutator\Support\Traits\MutatesNode;

class Heading extends \ProseMirrorToHtml\Nodes\Heading
{
    use MutatesNode;
}
