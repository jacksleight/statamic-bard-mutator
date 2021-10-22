<?php

namespace JackSleight\StatamicBardMutator\Nodes;

use JackSleight\StatamicBardMutator\Support\Traits\MutatesNode;

class Paragraph extends \ProseMirrorToHtml\Nodes\Paragraph
{
    use MutatesNode;
}
