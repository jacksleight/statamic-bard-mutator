<?php

namespace JackSleight\StatamicBardMutator\Tags;

use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Fields\Value;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class MutatorTag extends Tags
{
    protected static $handle = 'bmu';

    public function wildcard(string $name)
    {
        $value = Arr::get($this->context, $name);

        if (! $value instanceof Value) {
            return $value;
        }

        return Data::augment($value);
    }
}
