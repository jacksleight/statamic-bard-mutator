<?php

namespace JackSleight\StatamicBardMutator;

use closure;
use Statamic\Fieldtypes\Bard\Augmentor;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

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

    public function processRoot($root)
    {
        if (in_array($root, $this->roots, true)) {
            return;
        }

        $process = function ($data) use (&$process, $root) {
            if (isset($data->content)) {
                foreach ($data->content as $i => $node) {
                    $meta = new \stdClass;
                    $meta->parent = $data;
                    $meta->prev = $data->content[$i - 1] ?? null;
                    $meta->next = $data->content[$i + 1] ?? null;
                    $meta->index = $i;
                    $this->storeMeta($node, $meta);
                    $process($node);
                }
            }
            if (isset($data->marks)) {
                foreach ($data->marks as $i => $mark) {
                    $meta = new \stdClass;
                    $meta->parent = $data;
                    $meta->prev = $data->marks[$i - 1] ?? null;
                    $meta->next = $data->marks[$i + 1] ?? null;
                    $meta->index = $i;
                    $this->storeMeta($mark, $meta);
                    $process($mark);
                }
            }
        };
        $process($root);

        $this->roots[] = $root;
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

    public function mutateTag($kind, $type, $data, $tag)
    {
        $mutators = $this->getTagMutators($type);
        if (! count($mutators)) {
            return $tag;
        }

        $data = $this->normalizeData($data, $kind, $type);
        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($type, $tag);
            $tag = app()->call($mutator, [
                'kind' => $kind,
                'type' => $type,
                'data' => $data,
                $kind  => $data,
                'tag'  => $tag,
                'meta' => $meta,
            ]);
        }

        return $tag;
    }

    protected function normalizeTag($type, $tag)
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

    protected function normalizeData($data, $kind, $type)
    {
        if (! isset($data->attrs)) {
            $data->attrs = new \stdClass;
        }
        if ($kind === 'node') {
            if (! isset($data->content)) {
                $data->content = [];
            }
            if (! isset($data->marks)) {
                $data->marks = [];
            }
        }
        if ($kind === 'node' && $type === 'text') {
            if (! isset($data->text)) {
                $data->text = null;
            }
        }

        return $data;
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
