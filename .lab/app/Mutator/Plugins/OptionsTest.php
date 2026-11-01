<?php

namespace App\Mutator\Plugins;

use JackSleight\StatamicBardMutator\Plugins\Plugin;

class OptionsTest extends Plugin
{
    protected bool $scoped = true;

    protected array $types = ['bulletList'];

    protected array $options = ['label' => 'default'];

    public function render(array $value, object $info, array $params): ?array
    {
        $value[1]['data-label'] = $this->options()['label'] ?? 'none';

        return $value;
    }
}
