<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Plugins\ClosurePlugin;
use JackSleight\StatamicBardMutator\Plugins\Plugin;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Fieldtypes\Bard\Augmentor;

class Mutator
{
    protected $extensions = null;

    protected $plugins = [];

    protected $roots = [];

    protected $datas = [];

    protected $metas = [];

    protected $renders = [];

    protected $renderMarks = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addExtensions([
            'bmuRoot' => function ($bard) {
                return new Nodes\Root(['bard' => $bard->field()]);
            },
            'bmuHtml' => new Nodes\Html(),
        ]);
    }

    public function injectRoot($value)
    {
        $value = [[
            'type' => 'bmuRoot',
            'content' => $value,
        ]];

        return $value;
    }

    public function processRoot($data, array $extra)
    {
        if (in_array($data, $this->roots, true)) {
            return;
        }

        $this->roots[] = $data;

        Data::walk($data, function ($data, $meta) use ($extra) {
            $this->storeMeta($data, array_merge($meta, $extra));
            $this->mutateData($data->type, $data);
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

        foreach ($plugin->plugins() as $childPlugin) {
            $this->plugin($childPlugin);
        }

        return $plugin;
    }

    public function plugins($type)
    {
        return collect($this->plugins)
            ->filter(fn ($plugin) => ! $type || in_array($type, $plugin->types()))
            ->all();
    }

    public function data($types, Closure $process)
    {
        return $this->plugin(new ClosurePlugin($types, process: $process));
    }

    public function html($types, Closure $render, ?Closure $parse = null)
    {
        return $this->plugin(new ClosurePlugin($types, render: $render, parse: $parse))->global(true);
    }

    public function mutateData($type, $data)
    {
        if (! $plugins = $this->plugins($type)) {
            return;
        }

        $meta = $this->fetchMeta($data);

        foreach ($plugins as $plugin) {
            $plugin->process($data, $meta);
        }
    }

    public function mutateHtml($kind, $type, $value, array $params = [], $phase = null)
    {
        if ($kind === 'render' && $stored = $this->fetchRender($params['data'], $phase)) {
            return $stored;
        }

        if (! $plugins = $this->plugins($type)) {
            return $value;
        }

        $meta = isset($params['data'])
            ? $this->fetchMeta($params['data'])
            : null;

        foreach ($plugins as $plugin) {
            $value = Value::normalize($kind, $value);
            $value = $plugin->$kind($value, $meta, $params);
        }

        if ($kind === 'render') {
            $this->storeRender($params['data'], $value, $phase);
        }

        return $value;
    }

    protected function storeMeta($data, $meta)
    {
        $this->storeData($data);
        $this->metas[spl_object_id($data)] = $meta;
    }

    protected function fetchMeta($data)
    {
        return $this->metas[spl_object_id($data)] ?? null;
    }

    protected function storeRender($data, $render, $phase)
    {
        $this->storeData($data);
        $this->renders[spl_object_id($data)] = $render;

        if ($phase === 'mark:open') {
            $this->renderMarks[$data->type] = $render;
        }
    }

    protected function fetchRender($data, $phase)
    {
        $render = $this->renders[spl_object_id($data)] ?? null;

        if ($phase === 'mark:close') {
            $render = $render ?? $this->renderMarks[$data->type] ?? null;
            unset($this->renderMarks[$data->type]);
        }

        return $render;
    }

    protected function storeData($data)
    {
        $this->datas[spl_object_id($data)] = $data;
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
     * @deprecated
     */
    public function tag($types, Closure $mutator)
    {
        $this->renderHtml($types, function ($value, $data, $meta) use ($mutator) {
            return Value::tagToHtml(Value::normalizeTag($mutator(Value::htmlToTag($value), $data, $meta)));
        });
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
