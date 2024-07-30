<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class RemoveOuterParagraphs extends Data
{
    protected array $options = [
        'types' => ['image'],
    ];

    public function types(): array
    {
        return $this->options['types'];
    }

    public function process(object $data, array $meta): void
    {
    }
}
