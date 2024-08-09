<?php

namespace JackSleight\StatamicBardMutator\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Tiptap\Core\Node;

trait Mutates
{
    public function mutate($mode, $value, array $params = [], $phase = null)
    {
        return Mutator::mutateHtml($mode, static::$name, $value, $params, $phase);
    }

    public function parseHTML()
    {
        return $this->mutate('parse', parent::parseHTML());
    }

    public function renderHTML($item, $HTMLAttributes = [])
    {
        $phase = ($this instanceof Node ? 'node' : 'mark').':'.(func_num_args() === 2 ? 'open' : 'close');

        return $this->mutate('render', parent::renderHTML($item, $HTMLAttributes), [
            'item' => $item,
            'HTMLAttributes' => $HTMLAttributes,
        ], $phase);
    }
}
