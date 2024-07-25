<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Agents\Agent;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use ReflectionClass;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Support\Arr;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $agents = [];

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

    public function agent(Agent $agent)
    {
        foreach ($agent->types() as $type) {
            $this->registerType($type);
        }

        $this->agents[] = $agent;

        return $agent;
    }

    public function anonymousAgent($types, $kind, Closure $closure)
    {
        return $this->agent(new class($types, $kind, $closure) extends Agent
        {
            protected $kind;

            protected $closure;

            public function __construct($types, $kind, Closure $closure)
            {
                $this->types = Arr::wrap($types);
                $this->kind = $kind;
                $this->closure = $closure->bindTo($this);
            }

            public function processData()
            {
                return $this->kind === 'data'
                    ? $this->closure
                    : fn ($data) => $data;
            }

            public function renderHtml()
            {
                return $this->kind === 'renderHtml'
                    ? $this->closure
                    : fn ($value) => $value;
            }

            public function parseHtml()
            {
                return $this->kind === 'parseHtml'
                    ? $this->closure
                    : fn ($value) => $value;
            }
        });
    }

    public function data($types, Closure $closure)
    {
        $this->anonymousAgent($types, 'data', $closure);
    }

    public function parseHtml($types, Closure $closure)
    {
        $this->anonymousAgent($types, 'parseHtml', $closure);
    }

    public function renderHtml($types, Closure $closure)
    {
        $this->anonymousAgent($types, 'renderHtml', $closure);
    }

    public function html($types, Closure $renderHtmlClosure, Closure $parseHtmlClosure = null)
    {
        $this->renderHtml($types, $renderHtmlClosure);
        if ($parseHtmlClosure) {
            $this->parseHtml($types, $parseHtmlClosure);
        }
    }

    protected function agents($type)
    {
        return collect($this->agents)
            ->filter(fn ($agent) => in_array($type, $agent->types()))
            ->all();
    }

    public function mutateData($type, $data)
    {
        $agents = $this->agents($type);
        if (! $agents) {
            return;
        }

        $meta = $this->fetchMeta($data);

        foreach ($agents as $agent) {
            $callable = (new ReflectionClass($agent))->isAnonymous()
                ? $agent->processData()
                : [$agent, 'processData'];
            app()->call($callable, [
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

        $agents = $this->agents($type);

        $meta = isset($params['data'])
            ? $this->fetchMeta($params['data'])
            : null;

        foreach ($agents as $agent) {
            $callable = (new ReflectionClass($agent))->isAnonymous()
                ? $agent->$kind()
                : [$agent, $kind];
            $value = Value::normalize($kind, $value);
            $value = app()->call($callable, [
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
