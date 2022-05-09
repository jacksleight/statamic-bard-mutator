<?php

namespace JackSleight\StatamicBardMutator\Tags;

use JackSleight\StatamicBardMutator\Exceptions\NotValueException;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Fields\Value;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class MutatorTag extends Tags
{
    protected static $handle = 'bmu';

    public function wildcard(string $name)
    {
        $this->params->put('name', $name);

        return $this->index();
    }

    public function index()
    {
        $name = $this->params->get('name');
        $value = $this->params->get('value');

        $value = $value ?? $this->context->get($name);

        if (! $value instanceof Value) {
            throw new NotValueException();
        }

        return Mutator::render($value);
    }
}
