<?php

namespace JackSleight\StatamicBardMutator\Support;

class Value
{
    public static function normalize($kind, $value)
    {
        return static::{'normalize'.ucfirst($kind)}($value);
    }

    public static function normalizeRenderHtml($value)
    {
        if (! isset($value)) {
            return $value;
        }
        if (! isset($value[1]) || ! is_array($value[1])) {
            array_splice($value, 1, 0, [[]]);
        }
        if (isset($value[2]) && is_array($value[2])) {
            $value[2] = static::normalizeRenderHtml($value[2]);
        }

        return $value;
    }

    public static function normalizeParseHtml($value)
    {
        if (! isset($value)) {
            return $value;
        }
        if (! isset($value[1]) || ! is_array($value[1])) {
            array_splice($value, 1, 0, [[]]);
        }
        if (isset($value[2]) && is_array($value[2])) {
            $value[2] = static::normalizeRendervalue($value[2]);
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
            'tag'   => $html[0],
            'attrs' => $html[1],
        ]];
        if (isset($html[2]) && is_array($html[2])) {
            $tag = array_merge($tag, static::htmlToTag($html[2]));
        }

        return $tag;
    }

    /**
     * @deprecated
     */
    public static function tagToHtml($tag)
    {
        $first = array_shift($tag);
        $html = [$first['tag'], $first['attrs'], 0];
        if (count($tag)) {
            $html[2] = static::tagToHtml($tag);
        }

        return $html;
    }
}
