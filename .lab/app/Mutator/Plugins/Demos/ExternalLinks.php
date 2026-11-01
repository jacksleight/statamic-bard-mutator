<?php

namespace App\Mutator\Plugins\Demos;

use JackSleight\StatamicBardMutator\Plugins\Plugin;
use Statamic\Facades\URL;

class ExternalLinks extends Plugin
{
    protected array $types = ['link'];

    protected bool $scoped = true;

    public function render(
        array $value,
        object $info,
        array $params,
    ): ?array {
        if (URL::isExternal($value[1]['href'])) {
            $value[1]['target'] = '_blank';
            $value[1]['rel'] = 'noopener';
        }

        return $value;
    }
}
