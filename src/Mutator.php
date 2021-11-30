<?php

namespace JackSleight\StatamicBardMutator;

use closure;
use Statamic\Fieldtypes\Bard\Augmentor;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $tagMutators = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;
    }

    public function getMutatedTypes()
    {
        return array_keys($this->tagMutators);
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

        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($type, $tag);
            $tag = $mutator($tag, $data);
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
