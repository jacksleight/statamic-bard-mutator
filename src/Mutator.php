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

    protected $tags = [];

    protected $datas = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addNode(Nodes\Root::class);
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
        if ($stored = $this->fetchTag($data)) {
            return $stored;
        }

        $mutators = $this->mutators['tag'][$type] ?? [];
        if (! count($mutators)) {
            return $tag;
        }

        $data = $this->normalizeData($data);
        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($tag);
            $tag = $mutator($tag, $data, $meta);
        }

        $this->storeTag($data, $tag);

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
        $this->storeData($data);
        $this->metas[spl_object_id($data)] = $meta;
    }

    protected function fetchMeta($data)
    {
        return $this->metas[spl_object_id($data)] ?? null;
    }

    protected function storeTag($data, $tag)
    {
        $this->storeData($data);
        $this->tags[spl_object_id($data)] = $tag;
    }

    protected function fetchTag($data)
    {
        return $this->tags[spl_object_id($data)] ?? null;
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
            $search = $this->extensions[$type][0];
            $replace = $this->extensions[$type][1];
            if (is_a($search, 'ProseMirrorToHtml\Nodes\Node', true)) {
                Augmentor::replaceNode($search, $replace);
            } elseif (is_a($search, 'ProseMirrorToHtml\Marks\Mark', true)) {
                Augmentor::replaceMark($search, $replace);
            }
        }
    }

    public function render(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }

    /**
     * @deprecated
     */
    protected function normalizeData($data)
    {
        if (! isset($data->attrs)) {
            $data->attrs = new \stdClass;
        }
        if (! isset($data->content)) {
            $data->content = [];
        }

        return $data;
    }

    /**
     * @deprecated
     */
    public function node($type, Closure $mutator)
    {
        $this->tag($type, $mutator);
    }

    /**
     * @deprecated
     */
    public function mark($type, Closure $mutator)
    {
        $this->tag($type, $mutator);
    }
}
