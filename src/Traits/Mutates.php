<?php

namespace JackSleight\StatamicBardMutator\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Tiptap\Core\Node;

trait Mutates
{
    public function mutate($kind, $value, array $params = [], $phase = null)
    {
        return Mutator::mutate($kind, static::$name, $value, $params, $phase);
    }

    public function parseHTML()
    {
        return $this->mutate('parseHtml', parent::parseHTML());
    }

    public function renderHTML($data, $HTMLAttributes = [])
    {
        $phase = ($this instanceof Node ? 'node' : 'mark').':'.(func_num_args() === 2 ? 'open' : 'close');

        return $this->mutate('renderHtml', parent::renderHTML($data, $HTMLAttributes), [
            'data' => $data,
            'HTMLAttributes' => $HTMLAttributes,
        ], $phase);
    }
}
