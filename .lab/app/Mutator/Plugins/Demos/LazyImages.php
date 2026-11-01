<?php

namespace App\Mutator\Plugins\Demos;

use JackSleight\StatamicBardMutator\Plugins\Plugin;

class LazyImages extends Plugin
{
    protected array $types = ['image'];

    protected bool $scoped = true;

    public function render($value, ...$args): array
    {
        $value[1]['loading'] = 'lazy';

        return $value;
    }
}
