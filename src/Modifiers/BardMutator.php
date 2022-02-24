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
        if (! is_array($value)) {
            return $value;
        }

        $context = array_get($params, 0);

        $wrapped = [[
            'type' => 'bmu_root',
            'attrs' => [
                'context' => $context,
            ],
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
