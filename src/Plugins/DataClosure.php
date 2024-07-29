<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use Closure;
use Statamic\Support\Arr;

class DataClosure extends Data
{
    protected Closure $process;

    public function __construct(array|string $types, Closure $process)
    {
        $this->types = Arr::wrap($types);
        $this->process = $process;
    }

    public function process(object $data, array $meta): void
    {
        app()->call($this->process, [
            'type' => $data->type,
            'meta' => $meta,
            'data' => $data,
        ]);
    }
}
