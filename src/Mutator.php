<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use JackSleight\StatamicBardMutator\Support\Value;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value as StatamicValue;
use Statamic\Fieldtypes\Bard;
use Statamic\Support\Arr;

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

    public function mutator($types, $kind, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            if ($kind !== 'data') {
                $this->registerType($type);
            }
            if (!isset($this->mutators[$type])) {
                $this->mutators[$type] = [];
            }
            if (!isset($this->mutators[$type][$kind])) {
                $this->mutators[$type][$kind] = [];
            }
            $this->mutators[$type][$kind][] = $mutator;
        }
    }

    public function type($types, array $mutators)
    {
        foreach ($mutators as $kind => $mutator) {
            $this->mutator($types, $kind, $mutator);
        }
    }

    public function data($types, Closure $mutator)
    {
        $this->mutator($types, 'data', $mutator);
    }

    public function renderHtml($types, Closure $mutator)
    {
        $this->mutator($types, 'renderHtml', $mutator);
    }

    public function parseHtml($types, Closure $mutator)
    {
        $this->mutator($types, 'parseHtml', $mutator);
    }

    public function __call($method, $args)
    {
        $this->type($method, is_array($args[0])
            ? $args[0]
            : Arr::removeNullValues([
                'renderHtml' => $args[0] ?? null,
                'parseHtml' => $args[1] ?? null,
            ])
        );
    }

    public function mutateData($type, $data)
    {
        $mutators = $this->mutators[$type]['data'] ?? [];
        if (! count($mutators)) {
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
        $mutators = $this->mutators[$type][$kind] ?? [];
        if (! count($mutators)) {
            return $value;
        }

        $meta = isset($params['data'])
            ? $this->fetchMeta($params['data'])
            : null;;

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
            $class = $this->extensions[$type];
            Augmentor::replaceExtension($type, new $class());
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
        $this->mutator($types, 'renderHtml', function ($value, $data, $meta) use ($mutator) {
            return Value::tagToHtml(Value::normalizeTag($mutator(Value::htmlToTag($value), $data, $meta)));
        });
    }
}
