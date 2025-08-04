<?php

namespace JackSleight\StatamicBardMutator\Support;

use Closure;
use JackSleight\StatamicBardMutator\Facades\Mutator;

class Data
{
    public static function walk(object $item, Closure $callback): void
    {
        $step = function ($item, $meta) use (&$callback, &$step) {
            $callback($item, $meta);
            foreach (($item->content ?? []) as $i => $node) {
                $step($node, [
                    'parent' => $item,
                    'prev' => $item->content[$i - 1] ?? null,
                    'next' => $item->content[$i + 1] ?? null,
                    'index' => $i,
                    'depth' => $meta['depth'] + 1,
                    'root' => $meta['root'],
                ]);
            }
            foreach (($item->marks ?? []) as $i => $mark) {
                $step($mark, [
                    'parent' => $item,
                    'prev' => $item->marks[$i - 1] ?? null,
                    'next' => $item->marks[$i + 1] ?? null,
                    'index' => $i,
                    'depth' => $meta['depth'] + 1,
                    'root' => $meta['root'],
                ]);
            }
        };
        $step($item, [
            'parent' => null,
            'prev' => null,
            'next' => null,
            'index' => 0,
            'depth' => 0,
            'root' => $item,
        ]);
    }

    public static function node(string $type, ?array $attrs = null, ?array $content = null, ?array $marks = null): object
    {
        $item = (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
            'content' => ($content ?? []),
            'marks' => ($marks ?? []),
        ];

        Mutator::setProcessed($item);

        return $item;
    }

    public static function mark(string $type, ?array $attrs = null): object
    {
        $item = (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
        ];

        Mutator::setProcessed($item);

        return $item;
    }

    public static function text(string $text, ?array $marks = null): object
    {
        $item = (object) [
            'type' => 'text',
            'text' => $text,
            'marks' => ($marks ?? []),
        ];

        Mutator::setProcessed($item);

        return $item;
    }

    public static function html(string $html, ?array $attrs = null, ?array $content = null, ?array $marks = null): object
    {
        $item = preg_match('/^[a-z][a-z0-9-]*$/i', $html)
            ? (object) [
                'type' => 'bmuHtml',
                'render' => [$html, ($attrs ?? []), 0],
                'content' => ($content ?? []),
                'marks' => ($marks ?? []),
            ] : (object) [
                'type' => 'bmuHtml',
                'render' => ['content' => $html],
                'marks' => ($attrs ?? []),
            ];

        Mutator::setProcessed($item);

        return $item;
    }

    public static function apply(object $item, ...$properties): object
    {
        foreach ($properties as $key => $value) {
            if ($key === 'attrs' || $key === 'info') {
                $value = (object) $value;
            }
            $item->$key = $value;
        }

        Mutator::setProcessed($item);

        return $item;
    }

    public static function clone(object $item, ...$properties): object
    {
        return static::apply(clone $item, ...$properties);
    }

    public static function morph(object $item, object $into): object
    {
        foreach ($item as $key => $value) {
            unset($item->$key);
        }
        foreach ($into as $key => $value) {
            $item->$key = $value;
        }

        Mutator::setProcessed($item);

        return $item;
    }
}
