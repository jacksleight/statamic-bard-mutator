<?php

namespace JackSleight\StatamicBardMutator\Tags;

use Statamic\Tags\Tags;

/**
 * @deprecated
 */
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

        return $value;
    }
}