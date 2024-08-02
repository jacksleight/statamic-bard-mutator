<?php

namespace JackSleight\StatamicBardMutator\Support;

use Closure;

class Data
{
    public static function walk(object $data, Closure $callback): void
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
        $step($data, [
            'parent' => null,
            'prev' => null,
            'next' => null,
            'index' => 0,
            'depth' => 0,
            'root' => $data,
        ]);
    }

    public static function node(string $type, array $attrs = null, array $content = null): object
    {
        return (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
            'content' => ($content ?? []),
            'info' => (object) [
                'processed' => true,
            ],
        ];
    }

    public static function mark(string $type, array $attrs = null): object
    {
        return (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
            'info' => (object) [
                'processed' => true,
            ],
        ];
    }

    public static function text(string $text): object
    {
        return (object) [
            'type' => 'text',
            'text' => $text,
            'info' => (object) [
                'processed' => true,
            ],
        ];
    }

    public static function html(string $html, array $attrs = null, array $content = null): object
    {
        return preg_match('/^[a-z][a-z0-9-]*$/i', $html)
            ? (object) [
                'type' => 'bmuHtml',
                'html' => [$html, ($attrs ?? []), 0],
                'content' => ($content ?? []),
                'info' => (object) [
                    'processed' => true,
                ],
            ] : (object) [
                'type' => 'bmuHtml',
                'html' => ['content' => $html],
                'info' => (object) [
                    'processed' => true,
                ],
            ];
    }

    public static function apply(object $item, ...$properties): object
    {
        foreach ($properties as $key => $value) {
            if ($key === 'attrs' || $key === 'info') {
                $value = (object) $value;
            }
            $item->$key = $value;
        }

        // @todo This can be tidied up once the meta refactoring is in place
        $item->info = (object) ['processed' => true];

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

        // @todo This can be tidied up once the meta refactoring is in place
        $item->info = (object) ['processed' => true];

        return $item;
    }
}
