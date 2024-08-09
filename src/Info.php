<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator;

class Info
{
    public function __construct(
        protected $item,
        protected $parent,
        protected $prev,
        protected $next,
        protected $index,
        protected $depth,
        protected $root,
        protected $bard,
    ) {
    }

    public function __get($key)
    {
        if (in_array($key, ['parent', 'prev', 'next'])) {
            return Mutator::fetchInfo($this->{$key});
        }

        return $this->item->{$key} ?? $this->{$key};
    }

    public function __set($key, $value)
    {
        throw new \Exception('Unable to set property on Info object, use $info->item to access the actual node/mark');
    }

    // @deprecated 3.0.0
    public function meta()
    {
        return [
            'parent' => $this->parent,
            'prev' => $this->prev,
            'next' => $this->next,
            'index' => $this->index,
            'depth' => $this->depth,
            'root' => $this->root,
            'bard' => $this->bard,
        ];
    }
}
