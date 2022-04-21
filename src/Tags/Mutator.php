<?php

namespace JackSleight\StatamicBardMutator\Tags;

use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Tags\Tags;
use Statamic\Support\Arr;

class Mutator extends Tags
{
    protected static $handle = 'bmu';

    public function wildcard(string $name)
    {        
        $value = Arr::get($this->context, $name);
        
        $raw = $value instanceof Value
            ? $value->raw()
            : $value;
            
        if (! is_array($raw)) {
            return $value;
        }

        $wrapped = [[
            'type' => 'bmu_root',
            'content' => $raw,
        ]];

        $value = new Value(
            $wrapped,
            null,
            new Bard(),
        );

        return $value;
    }
}
