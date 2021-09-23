<?php

namespace JackSleight\BardMutator;

use closure;

class Mutator
{
    public $nodeMutators = [];

    public $markMutators = [];

    public function node($nodeType, closure $mutator)
    {
        $this->nodeMutators[$nodeType][] = $mutator;
    }

    public function mark($markType, closure $mutator)
    {
        $this->markMutators[$markType][] = $mutator;
    }

    public function getNodeMutators($nodeType)
    {
        return $this->nodeMutators[$nodeType] ?? [];
    }

    public function getMarkMutators($markType)
    {
        return $this->markMutators[$markType] ?? [];
    }

    public function mutateNode($nodeType, $node, $tag)
    {
        $mutators = $this->getNodeMutators($nodeType);
        if (!count($mutators)) {
            return $tag;
        }

        $node = $this->normalizeData($node);
        
        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($tag);
            $tag = $mutator($tag, $node);
        }

        return $tag;
    }

    public function mutateMark($markType, $mark, $tag)
    {
        $mutators = $this->getMarkMutators($markType);
        if (!count($mutators)) {
            return $tag;
        }

        $mark = $this->normalizeData($mark);
        
        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($tag);
            $tag = $mutator($tag, $mark);
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
}
