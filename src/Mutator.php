<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Support\Arr;

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
            'bmuRoot' => new Nodes\Root(),
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

    public function processRoot($data)
    {
        if (in_array($data, $this->roots, true)) {
            return;
        }

        $this->roots[] = $data;

        Data::walk($data, function ($data, $meta) {
            $this->storeMeta(['data' => $data], $meta);
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

        $meta = $this->fetchMeta(['data' => $data]);

        foreach ($mutators as $mutator) {
            app()->call($mutator, [
                'type' => $type,
                'meta' => $meta,
                'data' => $data,
            ]);
        }
    }

    public function mutate($kind, $type, $value, array $params = [])
    {
        if ($kind === 'renderHtml' && $stored = $this->fetchRenderHTML($params)) {
            return $stored;
        }

        $mutators = $this->mutators($type, $kind);

        $meta = isset($params['data'])
            ? $this->fetchMeta($params)
            : null;

        foreach ($mutators as $mutator) {
            $value = Value::normalize($kind, $value);
            $value = app()->call($mutator, [
                'type' => $type,
                'meta' => $meta,
                'value' => $value,
            ] + Arr::except($params, ['extensionType', 'callType']));
        }

        if ($kind === 'renderHtml') {
            $this->storeRenderHTML($params, $value);
        }

        return $value;
    }

    protected function storeMeta($params, $meta)
    {
        $this->storeData($params);
        $this->metas[spl_object_id($params['data'])] = $meta;
    }

    protected function fetchMeta($params)
    {
        return $this->metas[spl_object_id($params['data'])] ?? null;
    }

    protected function storeRenderHTML($params, $renderHTML)
    {
        $this->storeData($params);
        $this->renderHTMLs[spl_object_id($params['data'])] = $renderHTML;

        if ($params['extensionType'] === 'mark' && $params['callType'] === 'open') {
            $this->renderMarkHTMLs[$params['data']->type] = $renderHTML;
        }
    }

    protected function fetchRenderHTML($params)
    {
        $renderHTML = $this->renderHTMLs[spl_object_id($params['data'])] ?? null;

        if ($params['extensionType'] === 'mark' && $params['callType'] === 'close') {
            $renderHTML = $renderHTML ?? $this->renderMarkHTMLs[$params['data']->type] ?? null;
            unset($this->renderMarkHTMLs[$params['data']->type]);
        }

        return $renderHTML;
    }

    protected function storeData($params)
    {
        $this->datas[spl_object_id($params['data'])] = $params['data'];
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
