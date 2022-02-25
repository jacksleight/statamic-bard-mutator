<?php

namespace JackSleight\StatamicBardMutator\Modifiers;

use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Modifiers\Modifier;

class BardMutator extends Modifier
{
    protected static $aliases = ['bmu'];

    public function index($value, $params)
    {
        $raw = $value;

        if ($raw instanceof Value) {
            $raw = $raw->raw();
        }
        if (! is_array($raw)) {
            return $value;
        }

        $wrapped = [[
            'type' => 'bmu_root',
            'content' => $value,
        ]];

        $value = new Value(
            $wrapped,
            null,
            new Bard(),
        );

        return $value;
    }
}
