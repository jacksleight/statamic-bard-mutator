<?php
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;

if (! function_exists('bard_mutator')) {
    function bard_mutator($value)
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
