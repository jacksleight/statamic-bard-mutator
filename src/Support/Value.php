<?php

namespace JackSleight\StatamicBardMutator\Support;

class Value
{
    public static function normalize($mode, $value)
    {
        return static::{'normalize'.ucfirst($mode)}($value);
    }

    public static function normalizeRender($value)
    {
        if (! isset($value) || isset($value['content'])) {
            return $value;
        }
        if (! isset($value[1]) || ! is_array($value[1])) {
            array_splice($value, 1, 0, [[]]);
        }
        if (isset($value[2]) && is_array($value[2])) {
            $value[2] = static::normalizeRender($value[2]);
        }

        return $value;
    }

    public static function castRender($value)
    {
        if (! is_array($value) || isset($value['content'])) {
            return $value;
        }
        if (isset($value[1]) && is_array($value[1]) && ! array_is_list($value[1])) {
            $value[1] = array_map(fn ($attr) => is_int($attr) ? (string) $attr : $attr, $value[1]);
        }
        foreach ($value as $index => $item) {
            if (is_int($index) && $index >= 1 && is_array($item) && array_is_list($item)) {
                $value[$index] = static::castRender($item);
            }
        }

        return $value;
    }

    public static function normalizeParse($value)
    {
        if (! isset($value)) {
            return $value;
        }
        if (! isset($value[1]) || ! is_array($value[1])) {
            array_splice($value, 1, 0, [[]]);
        }

        return $value;
    }
}
