<?php

namespace JackSleight\StatamicBardMutator\Nodes;

class Html extends \Tiptap\Core\Node
{
    public static $name = 'bmuHtml';

    public function renderHTML($node, $HTMLAttributes = [])
    {
        if (is_string($node->html)) {
            return ['content' => $node->html ?? null];
        }

        return $node->html;
    }
}
