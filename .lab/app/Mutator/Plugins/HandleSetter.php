<?php

namespace App\Mutator\Plugins;

use JackSleight\StatamicBardMutator\Plugins\Plugin;

class HandleSetter extends Plugin
{
    protected array $types = ['blockquote'];

    public function render(array $value, object $info, array $params): ?array
    {
        $value[1]['data-handle-setter'] = $this->handle();

        return $value;
    }
}
