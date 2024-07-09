<?php

namespace JackSleight\StatamicBardMutator\Nodes;

class Html extends \Tiptap\Core\Node
{
    public static $name = 'bmuHtml';

    public function renderHTML($node, $HTMLAttributes = [])
    {
        $html = $node->html ?? null;

        if (is_string($html)) {
            return ['content' => $html];
        }

        return $html;
    }
}
