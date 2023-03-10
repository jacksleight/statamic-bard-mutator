<?php

namespace JackSleight\StatamicBardMutator\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use Tiptap\Core\Node;

trait Mutates
{
    public function mutate($kind, $value, array $params = [])
    {
        return Mutator::mutate($kind, static::$name, $value, $params);
    }

    public function parseHTML()
    {
        return $this->mutate('parseHtml', parent::parseHTML());
    }

    public function renderHTML($data, $HTMLAttributes = [])
    {
        $extensionType = $this instanceof Node ? 'node' : 'mark';
        $callType = func_num_args() === 2 ? 'open' : 'close';

        return $this->mutate('renderHtml', parent::renderHTML($data, $HTMLAttributes), get_defined_vars());
    }
}
