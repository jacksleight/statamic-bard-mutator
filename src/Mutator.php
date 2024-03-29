<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Fieldtypes\Bard\Augmentor;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $mutators = [];

    protected $roots = [];

    protected $datas = [];

    protected $metas = [];

    protected $renderHTMLs = [];

    protected $renderMarkHTMLs = [];

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
        $value['content'] = [[
            'type' => 'bmuRoot',
            'content' => $value['content'],
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

    public function mutator($types, $kind, Closure $mutator, $config = [])
    {
        foreach ((array) $types as $type) {
            if ($kind !== 'data') {
                $this->registerType($type);
            }
            if (! isset($this->mutators[$type])) {
                $this->mutators[$type] = [];
            }
            if (! isset($this->mutators[$type][$kind])) {
                $this->mutators[$type][$kind] = [];
            }
            $this->mutators[$type][$kind][] = $config + [
                'function' => $mutator,
            ];
        }
    }

    public function data($types, Closure $mutator, $config = [])
    {
        $this->mutator($types, 'data', $mutator, $config);
    }

    public function parseHtml($types, Closure $mutator, $config = [])
    {
        $this->mutator($types, 'parseHtml', $mutator, $config);
    }

    public function renderHtml($types, Closure $mutator, $config = [])
    {
        $this->mutator($types, 'renderHtml', $mutator, $config);
    }

    public function html($types, Closure $renderHtml, Closure $parseHtml = null, $config = [])
    {
        $this->renderHtml($types, $renderHtml, $config);
        if ($parseHtml) {
            $this->parseHtml($types, $parseHtml, $config);
        }
    }

    protected function mutators($type, $kind)
    {
        $mutators = $this->mutators[$type][$kind] ?? [];

        return collect($mutators)
            ->pluck('function')
            ->all();
    }

    public function mutateData($type, $data)
    {
        $mutators = $this->mutators($type, 'data');
        if (! $mutators) {
            return;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            app()->call($mutator, [
                'type' => $type,
                'meta' => $meta,
                'data' => $data,
            ]);
        }
    }

    public function mutate($kind, $type, $value, array $params = [], $phase = null)
    {
        if ($kind === 'renderHtml' && $stored = $this->fetchRenderHTML($params['data'], $phase)) {
            return $stored;
        }

        $mutators = $this->mutators($type, $kind);

        $meta = isset($params['data'])
            ? $this->fetchMeta($params['data'])
            : null;

        foreach ($mutators as $mutator) {
            $value = Value::normalize($kind, $value);
            $value = app()->call($mutator, [
                'type' => $type,
                'meta' => $meta,
                'value' => $value,
            ] + $params);
        }

        if ($kind === 'renderHtml') {
            $this->storeRenderHTML($params['data'], $value, $phase);
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

    protected function storeRenderHTML($data, $renderHTML, $phase)
    {
        $this->storeData($data);
        $this->renderHTMLs[spl_object_id($data)] = $renderHTML;

        if ($phase === 'mark:open') {
            $this->renderMarkHTMLs[$data->type] = $renderHTML;
        }
    }

    protected function fetchRenderHTML($data, $phase)
    {
        $renderHTML = $this->renderHTMLs[spl_object_id($data)] ?? null;

        if ($phase === 'mark:close') {
            $renderHTML = $renderHTML ?? $this->renderMarkHTMLs[$data->type] ?? null;
            unset($this->renderMarkHTMLs[$data->type]);
        }

        return $renderHTML;
    }

    protected function storeData($data)
    {
        $this->datas[spl_object_id($data)] = $data;
    }

    protected function registerType($type)
    {
        if (in_array($type, $this->registered)) {
            return;
        }

        $this->registered[] = $type;

        if (isset($this->extensions[$type])) {
            Augmentor::replaceExtension($type, $this->extensions[$type]);
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
}
