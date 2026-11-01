<?php

namespace App\Mutator\Plugins;

use JackSleight\StatamicBardMutator\Plugins\Plugin;
use JackSleight\StatamicBardMutator\Support\Data;

class ClassTest extends Plugin
{
    protected bool $scoped = true;

    protected array $types = ['paragraph'];

    public function process(object $item, object $info): void
    {
        $item->content[] = Data::text(' [processed by ClassTest]');
    }

    public function render(array $value, object $info, array $params): ?array
    {
        $value[1]['class'] = 'class-test';

        return $value;
    }
}
