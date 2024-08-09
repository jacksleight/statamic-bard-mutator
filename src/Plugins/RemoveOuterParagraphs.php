<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class RemoveOuterParagraphs extends Plugin
{
    protected array $options = [
        'types' => ['image'],
    ];

    public function types(): array
    {
        return $this->options['types'];
    }

    public function process(object $item, object $info): void
    {
    }
}
