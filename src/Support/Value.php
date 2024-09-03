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
