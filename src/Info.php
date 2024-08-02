<?php

namespace JackSleight\StatamicBardMutator;

class Info
{
    protected $processed = false;

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
        return $this->item->{$key} ?? $this->{$key};
    }

    public function __set($key, $value)
    {
        throw new \Exception('Cannot set property on Info object, use $info->item if you need to modify the actual node/mark');
    }

    public function processed($processed = null)
    {
        if (func_num_args()) {
            $this->processed = $processed;

            return $this;
        }

        return $this->processed;
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
