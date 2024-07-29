<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class RemoveInnerParagraphs extends Data
{
    public function __construct(
        protected array $types = ['listItem', 'tableCell'],
    ) {
    }

    public function process(object $data, array $meta): void
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
    }
}
