<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $mutators = [
        'data' => [],
        'tag' => [],
    ];

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

    public function data($types, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            $this->mutators['data'][$type][] = $mutator;
        }
    }

    protected function mutateData($type, $data)
    {
        $mutators = $this->mutators['data'][$type] ?? [];
        if (! count($mutators)) {
            return;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $mutator($data, $meta);
        }
    }

    public function tag($types, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            $this->registerType($type);
            $this->mutators['tag'][$type][] = $mutator;
        }
    }

    public function mutateTag($type, $data, $tag)
    {
        $mutators = $this->mutators['tag'][$type] ?? [];
        if (! count($mutators)) {
            return $tag;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            // $tag = $this->normalizeTag($tag); !!!!!!!!!
            $tag = $mutator($tag, $data, $meta);
        }

        return $tag;
    }

    protected function normalizeTag($tag)
    {
        $tag = (array) $tag;
        foreach ($tag as $i => $t) {
            if (is_string($t)) {
                $t = ['tag' => $t];
            }
            $t += ['tag' => null, 'attrs' => []];
            $tag[$i] = $t;
        }

        return $tag;
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

    public function render(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }
}
