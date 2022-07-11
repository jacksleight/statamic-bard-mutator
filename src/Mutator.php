<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value as StatamicValue;
use Statamic\Fieldtypes\Bard;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $mutators = [];

    protected $roots = [];

    protected $metas = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addExtensions([
            'bmu_root' => new Nodes\Root(),
        ]);
    }

    public function injectRoot($value)
    {
        return [[
            'type' => 'bmu_root',
            'content' => $value,
        ]];
    }

    public function processRoot($data)
    {
        if (in_array($data, $this->roots, true)) {
            return;
        }

        $this->roots[] = $data;

        Data::walk($data, function ($data, $meta) {
            $this->storeMeta($data, $meta);
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
                'priority' => 100,
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
        if (! count($mutators)) {
            return false;
        }

        return collect($mutators)
            ->sortBy('priority')
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

    public function mutate($kind, $type, $value, array $params = [])
    {
        $mutators = $this->mutators($type, $kind);
        if (! $mutators) {
            return;
        }

        $meta = isset($params['data'])
            ? $this->fetchMeta($params['data'])
            : null;

        foreach ($mutators as $mutator) {
            $value = Value::normalize($kind, $value);
            $value = app()->call($mutator, [
                'type'  => $type,
                'meta'  => $meta,
                'value' => $value,
            ] + $params);
        }

        return $value;
    }

    protected function storeMeta($data, $meta)
    {
        $this->metas[spl_object_id($data)] = $meta;
    }

    protected function fetchMeta($data)
    {
        return $this->metas[spl_object_id($data)] ?? null;
    }

    protected function registerType($type)
    {
        if (in_array($type, $this->registered)) {
            return;
        }

        $this->registered[] = $type;

        if (isset($this->extensions[$type])) {
            $extension = $this->extensions[$type];
            Augmentor::replaceExtension($type, $extension);
        }
    }

    public function render(StatamicValue $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
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
