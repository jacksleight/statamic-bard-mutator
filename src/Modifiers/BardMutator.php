<?php

namespace JackSleight\StatamicBardMutator\Modifiers;

use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;
use Statamic\Modifiers\Modifier;

class BardMutator extends Modifier
{
    protected static $aliases = ['bmu'];

    public function index($value, $params, $context, $raw)
    {
        // dd($value, $params, $context, $raw);
        
        // $raw = $value;

        if ($raw instanceof Value) {
            $raw = $raw->raw();
        }
        if (! is_array($raw)) {
            return $value;
        }

        $wrapped = [[
            'type' => 'bmu_root',
            'content' => $raw,
        ]];

        $value = new Value(
            $wrapped,
            null,
            new Bard(),
        );

        return $value;
    }
}
