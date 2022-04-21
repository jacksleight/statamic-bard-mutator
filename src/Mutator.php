<?php

namespace JackSleight\StatamicBardMutator;

use closure;
use Statamic\Fieldtypes\Bard\Augmentor;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $dataMutators = [];

    protected $tagMutators = [];

    protected $roots = [];

    protected $metas = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addNode(Nodes\Root::class);
    }

    public function getMutatedTypes()
    {
        return array_keys($this->tagMutators);
    }

    public function data($type, closure $mutator)
    {
        $this->dataMutators[$type][] = $mutator;

        return $this;
    }

    public function getDataMutators($type)
    {
        return $this->dataMutators[$type] ?? [];
    }

    protected function mutateData($type, $data)
    {
        $mutators = $this->getDataMutators($type);
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

    public function storeMeta($obj, $meta)
    {
        $id = spl_object_id($obj);

        $this->metas[$id] = $meta;

        return $this;
    }

    public function fetchMeta($obj)
    {
        $id = spl_object_id($obj);

        if (! isset($this->metas[$id])) {
            return null;
        }

        return $this->metas[$id];
    }

    protected function registerType($type)
    {
        if (in_array($type, $this->registered)) {
            return;
        }
        $this->registered[] = $type;
        $this->tagMutators[$type] = [];
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

    public function processRoot($root)
    {
        if (in_array($root, $this->roots, true)) {
            return;
        }

        $process = function ($data, $meta = null) use (&$process) {

            $this->mutateData($data->type, $data);
            $this->storeMeta($data, $meta);

            if (isset($data->content)) {
                foreach ($data->content as $i => $node) {
                    $meta = new \stdClass;
                    $meta->parent = $data;
                    $meta->prev = $data->content[$i - 1] ?? null;
                    $meta->next = $data->content[$i + 1] ?? null;
                    $meta->index = $i;
                    $process($node, $meta);
                }
            }

            if (isset($data->marks)) {
                foreach ($data->marks as $i => $mark) {
                    $meta = new \stdClass;
                    $meta->parent = $data;
                    $meta->prev = $data->marks[$i - 1] ?? null;
                    $meta->next = $data->marks[$i + 1] ?? null;
                    $meta->index = $i;
                    $process($mark, $meta);
                }
            }

        };

        $process($root);

        $this->roots[] = $root;
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
