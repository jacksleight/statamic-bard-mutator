<?php

namespace JackSleight\BardMutator\Nodes;

use JackSleight\BardMutator\Support\Traits\MutatesNode;

class Paragraph extends \ProseMirrorToHtml\Nodes\Paragraph
{
    use MutatesNode;
}
