<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value;
use Statamic\Fields\Values;
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

    public function data($type, closure $mutator)
    {
        $this->mutators['data'][$type][] = $mutator;

        return $this;
    }

    protected function mutateData($type, $data)
    {
        $mutators = $this->mutators['data'][$type] ?? [];
        if (! count($mutators)) {
            return $data;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $mutator($data, $meta);
        }
    }

    public function tag($type, closure $mutator)
    {
        $this->registerType($type);
        $this->mutators['tag'][$type][] = $mutator;

        return $this;
    }

    public function mutateTag($type, $data, $tag)
    {
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

    protected function storeMeta($data, $meta)
    {
        $id = spl_object_id($data);

        $this->metas[$id] = $meta;

        return $this;
    }

    protected function fetchMeta($data)
    {
        $id = spl_object_id($data);

        return $this->metas[$id] ?? null;
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

    public function getMutatedTypes()
    {
        return array_keys($this->mutators['tag']);
    }

    public function render(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }

    // public function renderRecursive($value)
    // {
    //     if ($value instanceof Value) {
    //         if ($value->fieldtype() instanceof Bard) {
    //             $value = $this->render($value);
    //         } else {
    //             $value = $value->value();
    //         }
    //     }

    //     if (is_array($value)) {
    //         foreach ($value as $key => $item) {
    //             $value[$key] = $this->renderRecursive($item);
    //         }
    //     } else if ($value instanceof Values) {
    //         foreach ($value as $key => $item) {
    //             $value->getProxiedInstance()->put($key, $this->renderRecursive($item));
    //         }
    //     }

    //     return $value;
    // }

    /**
     * @deprecated
     */
    public function node($type, closure $mutator)
    {
        $this->tag($type, $mutator);
    }

    /**
     * @deprecated
     */
    public function mark($type, closure $mutator)
    {
        $this->tag($type, $mutator);
    }
}
