<?php

namespace App\Mutator\Plugins;

use JackSleight\StatamicBardMutator\Plugins\Plugin;

class HandleProperty extends Plugin
{
    protected ?string $handle = 'from_property';

    protected bool $scoped = true;

    protected array $types = ['heading'];

    public function render(array $value, object $info, array $params): ?array
    {
        $value[1]['data-handle-property'] = $this->handle();

        return $value;
    }
}
