<?php

namespace JackSleight\StatamicBardMutator\Support;

use Closure;
use JackSleight\StatamicBardMutator\Augmentor;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;

class Data
{
    public static function augment(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            return $value;
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }

    public static function walk($data, Closure $callback)
    {
        $step = function ($item, $meta = null) use (&$callback, &$step) {
            $callback($item, $meta);
            foreach (($item->content ?? []) as $i => $node) {
                $step($node, [
                    'parent' => $item,
                    'prev'   => $item->content[$i - 1] ?? null,
                    'next'   => $item->content[$i + 1] ?? null,
                    'index'  => $i,
                    'depth'  => $meta['depth'] + 1,
                ]);
            }
            foreach (($item->marks ?? []) as $i => $mark) {
                $step($mark, [
                    'parent' => $item,
                    'prev'   => $item->marks[$i - 1] ?? null,
                    'next'   => $item->marks[$i + 1] ?? null,
                    'index'  => $i,
                    'depth'  => $meta['depth'] + 1,
                ]);
            }
        };
        $step($data, [
            'parent' => null,
            'prev'   => null,
            'next'   => null,
            'index'  => 0,
            'depth'  => 0,
        ]);
    }
}
