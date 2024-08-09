<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class RemoveInnerParagraphs extends Plugin
{
    protected array $options = [
        'types' => ['listItem', 'tableCell'],
    ];

    public function types(): array
    {
        return $this->options['types'];
    }

    public function process(object $item, object $info): void
    {
        $content = $item->content ?? [];
        if (! $content) {
            return;
        }

        $onlyParagraphs = collect($content)
            ->doesntContain(fn ($node) => $node->type !== 'paragraph');
        if (! $onlyParagraphs) {
            return;
        }

        $item->content = collect($content)
            ->flatMap(fn ($node) => $node->content)
            ->all();
    }
}
