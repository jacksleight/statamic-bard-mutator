<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use Closure;
use Statamic\Support\Arr;

class HtmlClosure extends Html
{
    protected Closure $render;

    protected Closure $parse;

    public function __construct($types, Closure $render, Closure $parse)
    {
        $this->types = Arr::wrap($types);
        $this->render = $render;
        $this->parse = $parse;
    }

    public function render(array $value, array $meta, array $params): array
    {
        return app()->call($this->render, [
            'type' => $params['data']->type,
            'meta' => $meta,
            'value' => $value,
        ] + $params);
    }

    public function parse(array $value, array $meta, array $params): array
    {
        return app()->call($this->parse, [
            'type' => $params['data']->type,
            'meta' => $meta,
            'value' => $value,
        ] + $params);
    }
}
