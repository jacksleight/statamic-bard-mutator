<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use Statamic\Fieldtypes\Bard\Augmentor;

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

    public function getMutatedTypes()
    {
        return array_keys($this->tagMutators);
    }

    public function root(closure $mutator)
    {
        $this->rootMutators[] = $mutator;

        return $this;
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

        $collect = function () use ($data) {
            $items = [];
            $step = function ($item) use (&$items, &$step) {
                $items[] = $item;
                foreach (($item->content ?? []) as $node) {
                    $step($node);
                }
                foreach (($item->marks ?? []) as $mark) {
                    $step($mark);
                }
            };
            $step($data);

            return collect($items);
        };

        foreach ($mutators as $mutator) {
            app()->call($mutator, [
                'data' => $data,
                'collect' => $collect,
            ]);
        }
    }

    public function processRoot($root)
    {
        if (in_array($root, $this->roots, true)) {
            return;
        }

        $process = function ($data, $meta = null) use (&$process) {
            $this->storeMeta($data, $meta);
            foreach (($data->content ?? []) as $i => $node) {
                $meta = $this->buildMeta($data, $data->content[$i - 1] ?? null, $data->content[$i + 1] ?? null, $i);
                $process($node, $meta);
            }
            foreach (($data->marks ?? []) as $i => $mark) {
                $meta = $this->buildMeta($data, $data->marks[$i - 1] ?? null, $data->marks[$i + 1] ?? null, $i);
                $process($mark, $meta);
            }
        };

        $this->mutateRoot($root);
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

    protected function buildMeta($parent, $prev, $next, $index)
    {
        $meta = new \stdClass;
        $meta->parent = $parent;
        $meta->prev = $prev;
        $meta->next = $next;
        $meta->index = $index;

        return $meta;
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
