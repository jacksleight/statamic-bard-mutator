<?php

namespace JackSleight\StatamicBardMutator;

use Closure;
use JackSleight\StatamicBardMutator\Support\Data;
use Statamic\Exceptions\NotBardValueException;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard;

class Mutator
{
    protected $extensions = null;

    protected $registered = [];

    protected $mutators = [
        'data' => [],
        'html' => [],
        'tag' => [],
    ];

    protected $roots = [];

    protected $metas = [];

    public function __construct($extensions)
    {
        $this->extensions = $extensions;

        Augmentor::addExtensions([
            'bmu_root' => new Nodes\Root(),
        ]);
    }

    public function injectRoot($value)
    {
        return [[
            'type' => 'bmu_root',
            'content' => $value,
        ]];
    }

    public function processRoot($data)
    {
        if (in_array($data, $this->roots, true)) {
            return;
        }

        $this->roots[] = $data;

        Data::walk($data, function ($data, $meta) {
            $this->storeMeta($data, $meta);
            $this->mutateData($data->type, $data);
        });
    }

    public function data($types, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            $type = $this->mapType($type);
            $this->mutators['data'][$type][] = $mutator;
        }
    }

    protected function mutateData($type, $data)
    {
        $mutators = $this->mutators['data'][$type] ?? [];
        if (! count($mutators)) {
            return;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $mutator($data, $meta);
        }
    }

    public function html($types, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            $type = $this->mapType($type);
            $this->registerType($type);
            $this->mutators['html'][$type][] = $mutator;
        }
    }

    public function mutateHtmlCompat($data, $html)
    {
        $html = $this->mutateHtml($data, $html);
        $html = $this->mutateHtmlAsTag($data, $html);

        return $html;
    }

    public function mutateHtml($data, $html)
    {
        $mutators = $this->mutators['html'][$data->type] ?? [];
        if (! count($mutators)) {
            return $html;
        }

        $meta = $this->fetchMeta($data);

        foreach ($mutators as $mutator) {
            $html = $this->normalizeHtml($html);
            $html = $mutator($html, $data, $meta);
        }

        return $html;
    }

    protected function normalizeHtml($html)
    {
        if (! isset($html[1]) || ! is_array($html[1])) {
            array_splice($html, 1, 0, [[]]);
        }
        if (isset($html[2]) && is_array($html[2])) {
            $html[2] = $this->normalizeHtml($html[2]);
        }

        return $html;
    }

    protected function storeMeta($data, $meta)
    {
        $this->metas[spl_object_id($data)] = $meta;
    }

    protected function fetchMeta($data)
    {
        return $this->metas[spl_object_id($data)] ?? null;
    }

    protected function registerType($type)
    {
        if (in_array($type, $this->registered)) {
            return;
        }

        $this->registered[] = $type;

        if (isset($this->extensions[$type])) {
            $class = $this->extensions[$type];
            Augmentor::replaceExtension($type, new $class());
        }
    }

    public function render(Value $value)
    {
        if (! $value->fieldtype() instanceof Bard) {
            throw new NotBardValueException();
        }

        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }

    protected function mapType($type)
    {
        return [
            'bullet_list'     => 'bulletList',
            'code_block'      => 'codeBlock',
            'hard_break'      => 'hardBreak',
            'horizontal_rule' => 'horizontalRule',
            'list_item'       => 'listItem',
            'ordered_list'    => 'orderedList',
            'table_cell'      => 'tableCell',
            'table_header'    => 'tableHeader',
            'table_row'       => 'tableRow',
        ][$type] ?? $type;
    }

    /**
     * @deprecated
     */
    public function tag($types, Closure $mutator)
    {
        foreach ((array) $types as $type) {
            $type = $this->mapType($type);
            $this->registerType($type);
            $this->mutators['tag'][$type][] = $mutator;
        }
    }

    /**
     * @deprecated
     */
    public function mutateHtmlAsTag($data, $html)
    {
        $mutators = $this->mutators['tag'][$data->type] ?? [];
        if (! count($mutators)) {
            return $html;
        }

        $meta = $this->fetchMeta($data);

        $html = $this->normalizeHtml($html);
        $tag = $this->htmlToTag($html);
        foreach ($mutators as $mutator) {
            $tag = $this->normalizeTag($tag);
            $tag = $mutator($tag, $data, $meta);
        }
        $tag = $this->normalizeTag($tag);
        $html = $this->tagToHtml($tag);

        return $html;
    }

    /**
     * @deprecated
     */
    protected function normalizeTag($tag)
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
    protected function htmlToTag($html)
    {
        $tag = [[
            'tag'   => $html[0],
            'attrs' => $html[1],
        ]];
        if (isset($html[2]) && is_array($html[2])) {
            $tag = array_merge($tag, $this->htmlToTag($html[2]));
        }

        return $tag;
    }

    /**
     * @deprecated
     */
    protected function tagToHtml($tag)
    {
        $first = array_shift($tag);
        $html = [$first['tag'], $first['attrs'], 0];
        if (count($tag)) {
            $html[2] = $this->tagToHtml($tag);
        }

        return $html;
    }
}
