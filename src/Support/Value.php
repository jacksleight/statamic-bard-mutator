<?php

namespace JackSleight\StatamicBardMutator\Support;

class Value
{
    public static function normalize($kind, $value)
    {
        return static::{'normalize'.ucfirst($kind)}($value);
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

    /**
     * @deprecated
     */
    public static function normalizeTag($tag)
    {
        $tag = (array) $tag;
        foreach ($tag as $i => $t) {
            if (is_string($t)) {
                $t = ['tag' => $t];
            }
            $t += ['tag' => null, 'attrs' => []];
            $tag[$i] = $t;
        }

        return $tag;
    }

    /**
     * @deprecated
     */
    public static function htmlToTag($html)
    {
        $tag = [[
            'tag' => $html[0],
            'attrs' => $html[1],
        ]];
        foreach (array_slice($html, 2) as $inner) {
            if (is_array($inner)) {
                $tag[] = [
                    'tag' => $inner[0],
                    'attrs' => $inner[1],
                ];
            }
        }

        return $tag;
    }

    /**
     * @deprecated
     */
    public static function tagToHtml($tag)
    {
        $first = array_shift($tag);
        $html = [$first['tag'], $first['attrs']];
        if (count($tag)) {
            foreach ($tag as $inner) {
                $html[] = [$inner['tag'], $inner['attrs'], 0];
            }
        } else {
            $html[] = 0;
        }

        return $html;
    }
}
