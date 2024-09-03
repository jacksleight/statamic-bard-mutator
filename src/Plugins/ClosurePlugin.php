<?php

namespace JackSleight\StatamicBardMutator\Plugins;

use Closure;
use Statamic\Support\Arr;

class ClosurePlugin extends Plugin
{
    protected ?Closure $process;

    protected ?Closure $render;

    protected ?Closure $parse;

    public function handle(?string $handle = null): static|string|null
    {
        if (func_num_args()) {
            $this->handle = $handle;

            return $this;
        }

        return $this->handle;
    }

    public function __construct($types, ?Closure $process = null, ?Closure $render = null, ?Closure $parse = null)
    {
        $this->types = Arr::wrap($types);
        $this->process = $process;
        $this->render = $render;
        $this->parse = $parse;
    }

    public function process(object $item, object $info): void
    {
        if (! $this->process) {
            return;
        }

        // @deprecated 3.0.0 The type, data and meta keys are deprecated
        app()->call($this->process, [
            'item' => $info->item,
            'info' => $info,
            'type' => $info->type,
            'data' => $info->item,
            'meta' => $info->meta(),
        ]);
    }

    public function render(array $value, object $info, array $params): ?array
    {
        if (! $this->render) {
            return $value;
        }

        // @deprecated 3.0.0 The type, data and meta keys are deprecated
        return app()->call($this->render, [
            'value' => $value,
            'item' => $info->item,
            'info' => $info,
            'type' => $info->type,
            'data' => $info->item,
            'meta' => $info->meta(),
        ] + $params);
    }

    public function parse(array $value, object $info, array $params): array
    {
        if (! $this->parse) {
            return $value;
        }

        // @deprecated 3.0.0 The type, data and meta keys are deprecated
        return app()->call($this->parse, [
            'value' => $value,
            'item' => $info->item,
            'info' => $info,
            'type' => $info->type,
            'data' => $info->item,
            'meta' => $info->meta(),
        ] + $params);
    }
}
