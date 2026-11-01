<?php

namespace App\Mutator\Plugins\Demos;

use Illuminate\Support\Str;
use JackSleight\StatamicBardMutator\Plugins\Plugin;

class HeadingAnchors extends Plugin
{
    protected array $types = ['heading'];

    protected bool $scoped = true;

    public function render(
        array $value,
        object $info,
        array $params,
    ): ?array {
        $value[1]['id'] = Str::slug(collect($info->item->content)->implode('text'));

        return $value;
    }
}
