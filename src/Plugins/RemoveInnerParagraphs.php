<?php

namespace JackSleight\StatamicBardMutator\Agents;

class RemoveInnerParagraphs extends Agent
{
    protected $types = [
        'listItem',
        'tableCell',
    ];

    public function processData($data)
    {
        $content = $data->content ?? [];
        if (! $content) {
            return;
        }

        $onlyParagraphs = collect($content)
            ->doesntContain(fn ($node) => $node->type !== 'paragraph');
        if (! $onlyParagraphs) {
            return;
        }

        $data->content = collect($content)
            ->flatMap(fn ($node) => $node->content)
            ->all();

        return $data;
    }
}
