<?php

namespace JackSleight\StatamicBardMutator\Tags;

use JackSleight\StatamicBardMutator\Augmentor;
use Statamic\Fields\Value;
use Statamic\Tags\Tags;
use Statamic\Support\Arr;
use Statamic\Fieldtypes\Bard;

class MutatorTag extends Tags
{
    protected static $handle = 'bmu';

    public function wildcard(string $name)
    {        
        $value = Arr::get($this->context, $name);

        if (! $value instanceof Value || ! $value->fieldtype() instanceof Bard) {
            return $value;
        }
        
        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }
}
