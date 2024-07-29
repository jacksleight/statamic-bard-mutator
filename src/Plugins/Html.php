<?php

namespace JackSleight\StatamicBardMutator\Plugins;

class Html extends Plugin
{
    public function render(array $value, array $meta, array $params): array
    {
        return $value;
    }

    public function parse(array $value, array $meta, array $params): array
    {
        return $value;
    }
}
