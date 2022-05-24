<?php

namespace JackSleight\StatamicBardMutator\Traits;

use JackSleight\StatamicBardMutator\Facades\Mutator;

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
        return $this->mutate('renderHtml', parent::renderHTML($data, $HTMLAttributes), get_defined_vars());
    }
}
