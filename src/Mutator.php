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

    protected $rootMutators = [];

    protected $tagMutators = [];

    protected $roots = [];

    protected $metas = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addNode(Nodes\Root::class);
    }

    public static function augment(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }

    public function getMutatedTypes()
    {
        return array_keys($this->tagMutators);
    }

    public function root(closure $mutator)
    {
        $this->rootMutators[] = $mutator;

        return $this;
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

        $this->mutateRoot($data);
        Data::walk($data, function ($data, $meta) {
            $this->storeMeta($data, $meta);
        });

        $this->roots[] = $data;
    }

    public function getRootMutators()
    {
        return $this->rootMutators;
    }

    protected function mutateRoot($data)
    {
        $mutators = $this->getRootMutators();
        if (! count($mutators)) {
            return;
        }

        foreach ($mutators as $mutator) {
            $mutator($data);
        }
    }

    public function tag($type, closure $mutator)
    {
        $this->registerType($type);
        $this->tagMutators[$type][] = $mutator;

        return $this;
    }

    public function getTagMutators($type)
    {
        return $this->tagMutators[$type] ?? [];
    }

    public function mutateTag($type, $data, $tag)
    {
        $mutators = $this->getTagMutators($type);
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
