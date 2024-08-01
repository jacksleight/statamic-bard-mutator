<?php

namespace JackSleight\StatamicBardMutator\Support;

use Closure;
use Statamic\Support\Arr;

class Data
{
    public static function walk($data, Closure $callback)
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

    public static function node($type, $attrs = null, $content = null)
    {
        return (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
            'content' => ($content ?? []),
        ];
    }

    public static function mark($type, $attrs = null)
    {
        return (object) [
            'type' => $type,
            'attrs' => (object) ($attrs ?? []),
        ];
    }

    public static function text($text)
    {
        return (object) [
            'type' => 'text',
            'text' => $text,
        ];
    }

    public static function html($html, $attrs = null, $content = null)
    {
        if (func_num_args() > 1) {
            return (object) [
                'type' => 'bmuHtml',
                'html' => [$html, ($attrs ?? []), 0],
                'content' => ($content ?? []),
            ];
        }

        return (object) [
            'type' => 'bmuHtml',
            'html' => $html,
        ];
    }

    public static function morph($node, $newNode)
    {
        foreach ($node as $property => $value) {
            unset($node->$property);
        }
        foreach ($newNode as $property => $value) {
            $node->$property = $value;
        }
    }

    public static function clone($node, $attrs = null, $content = null)
    {
        $attrs = $attrs ?? $node->attrs ?? null;
        $content = $content ?? $node->content ?? null;

        $newNode = clone $node;
        if (isset($attrs)) {
            $newNode->attrs = clone (object) $attrs;
        }
        if (isset($content)) {
            $newNode->content = Arr::map($content, fn ($child) => Data::clone($child));
        }

        return $newNode;
    }
}
