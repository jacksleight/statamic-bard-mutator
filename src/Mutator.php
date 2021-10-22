<?php

namespace JackSleight\StatamicBardMutator;

use closure;

class Mutator
{
    public $tagMutators = [];

    public function tag($type, closure $mutator)
    {
        $this->tagMutators[$type][] = $mutator;
    }

    public function getTagMutators($type)
    {
        return $this->tagMutators[$type] ?? [];
    }

    public function mutateTag($type, $data, $tag)
    {
        $mutators = $this->getTagMutators($type);
        if (!count($mutators)) {
            return $tag;
        }

        $data = $this->normalizeData($data);
        
        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($tag);
            $tag = $mutator($tag, $data);
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

    protected function normalizeData($data)
    {
        if (!isset($data->attrs)) {
            $data->attrs = new \stdClass;
        }
        if (!isset($data->content)) {
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
