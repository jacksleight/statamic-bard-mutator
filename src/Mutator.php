<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Plugins\ClosurePlugin;
use JackSleight\StatamicBardMutator\Plugins\Plugin;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Fields\Field;
use Statamic\Fieldtypes\Bard\Augmentor;
use WeakMap;

class Mutator
{
    protected $extensions;

    protected $plugins = [];

    protected $processed;

    protected $infos;

    protected $renders;

    protected $renderMarks = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;
        $this->processed = new WeakMap;
        $this->infos = new WeakMap;
        $this->renders = new WeakMap;
    }

    public function injectRoot($value)
    {
        $value = [[
            'type' => 'bmuRoot',
            'content' => $value,
        ]];

        return $value;
    }

    public function processRoot($item, array $extra)
    {
        Data::walk($item, function ($item, $meta) use ($extra) {
            $this->storeInfo($item, new Info(
                item: $item,
                parent: $meta['parent'],
                prev: $meta['prev'],
                next: $meta['next'],
                index: $meta['index'],
                depth: $meta['depth'],
                root: $meta['root'],
                bard: $extra['bard'],
            ));
        });
        Data::walk($item, function ($item, $meta) {
            $this->mutateData($item->type, $item);
        });
    }

    public function plugin(string|Plugin $plugin)
    {
        if (is_string($plugin)) {
            $plugin = app($plugin);
        }

        foreach ($plugin->types() as $type) {
            $this->plugins[] = $plugin;
        }

        return $plugin;
    }

    public function plugins()
    {
        return $this->plugins;
    }

    public function selectablePlugins()
    {
        return collect($this->plugins)
            ->filter(fn ($plugin) => $plugin->scoped() && $plugin->handle())
            ->all();
    }

    public function filteredPlugins(?Field $bard, $type)
    {
        $plugins = $bard?->get('bmu_plugins', []) ?? [];

        return collect($this->plugins)
            ->filter(fn ($plugin) => ! $plugin->scoped() || in_array($plugin->handle(), $plugins))
            ->filter(fn ($plugin) => in_array($type, $plugin->types()))
            ->all();
    }

    public function data($types, Closure $process)
    {
        return $this->plugin(new ClosurePlugin($types, process: $process));
    }

    public function html($types, ?Closure $render = null, ?Closure $parse = null)
    {
        return $this->plugin(new ClosurePlugin($types, render: $render, parse: $parse));
    }

    public function mutateData($type, $item)
    {
        if ($this->isProcessed($item)) {
            return;
        }

        $info = $this->fetchInfo($item);

        if (! $plugins = $this->filteredPlugins($info->bard, $type)) {
            return;
        }

        foreach ($plugins as $plugin) {
            $plugin->process($item, $info);
        }

        $this->setProcessed($item);
    }

    public function mutateHtml($mode, $type, $value, array $params = [], $phase = null)
    {
        $item = $params['item'] ?? (object) [
            'type' => $type,
        ];

        if ($mode === 'render' && $stored = $this->fetchRender($item, $phase)) {
            return $stored;
        }

        $info = $this->fetchInfo($item);

        if (! $plugins = $this->filteredPlugins($info->bard ?? null, $type)) {
            return $value;
        }

        foreach ($plugins as $plugin) {
            $value = Value::normalize($mode, $value);
            $value = $plugin->$mode($value, $info, $params);
        }

        if ($mode === 'render') {
            $this->storeRender($item, $value, $phase);
        }

        return $value;
    }

    public function setProcessed($item)
    {
        $this->processed[$item] = true;
    }

    protected function isProcessed($item)
    {
        return $this->processed[$item] ?? false;
    }

    protected function storeInfo($item, $info)
    {
        $this->infos[$item] = $info;
    }

    public function fetchInfo($item)
    {
        return $this->infos[$item] ?? null;
    }

    protected function storeRender($item, $render, $phase)
    {
        $this->renders[$item] = $render;

        if ($phase === 'mark:open') {
            $this->renderMarks[$item->type] = $render;
        }
    }

    protected function fetchRender($item, $phase)
    {
        $render = $this->renders[$item] ?? null;

        if ($phase === 'mark:close') {
            $render = $render ?? $this->renderMarks[$item->type] ?? null;
            unset($this->renderMarks[$item->type]);
        }

        return $render;
    }

    public function registerExtensions()
    {
        $types = collect($this->plugins)
            ->map(fn ($plugin) => $plugin->types())
            ->flatten()
            ->unique()
            ->all();

        foreach ($types as $type) {
            if (isset($this->extensions[$type])) {
                Augmentor::replaceExtension($type, $this->extensions[$type]);
            }
        }
    }

    public function registerAllExtensions()
    {
        foreach ($this->extensions as $type => $extension) {
            Augmentor::replaceExtension($type, $extension);
        }
    }

    /**
     * @deprecated 3.0.0 Use `Mutator::html($types, $closure)` instead
     */
    public function renderHtml($types, Closure $closure)
    {
        return $this->html($types, $closure, null);
    }

    /**
     * @deprecated 3.0.0 Use `Mutator::html($types, null, $closure)` instead
     */
    public function parseHtml($types, Closure $closure)
    {
        return $this->html($types, null, $closure);
    }
}
