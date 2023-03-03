<?php

namespace JackSleight\StatamicBardMutator\Nodes;

class Html extends \Tiptap\Core\Node
{
    public static $name = 'bmuHtml';

    public function renderHTML($node, $HTMLAttributes = [])
    {
        return ['content' => $node->html ?? null];
    }
}
