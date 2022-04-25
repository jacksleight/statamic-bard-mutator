<?php

namespace JackSleight\StatamicBardMutator\Support;

use Closure;

class Data
{
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
            'depth'  => $data->type === 'bmu_root' ? -1 : 0,
        ]);
    }
}
