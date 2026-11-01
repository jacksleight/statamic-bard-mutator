<?php

namespace App\Tags;

use Dom\HTMLDocument;
use Dom\Node;
use Illuminate\Support\Facades\File;
use JackSleight\StatamicBardMutator\Facades\Mutator;
use Statamic\Tags\Tags;

class Lab extends Tags
{
    protected array $blocks = [
        'aside', 'blockquote', 'div', 'figcaption', 'figure', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'li',
        'ol', 'p', 'picture', 'pre', 'table', 'tbody', 'td', 'th', 'thead', 'tr', 'ul',
    ];

    public function plugins(): array
    {
        return collect(Mutator::plugins())->map(fn ($plugin) => [
            'class' => class_basename($plugin),
            'handle' => $plugin->handle(),
            'display' => $plugin->handle() ? $plugin->display() : null,
            'scoped' => $plugin->scoped(),
            'types' => implode(', ', $plugin->types()),
            'options' => $plugin->options() ? json_encode($plugin->options()) : null,
        ])->all();
    }

    public function source(): string
    {
        return e(File::get(app_path('Mutator/'.$this->params->get('file').'.php')));
    }

    public function pretty(): string
    {
        $html = (string) $this->context->get($this->params->get('field', 'content'));
        $doc = HTMLDocument::createFromString('<!doctype html><body>'.$html.'</body>', LIBXML_NOERROR);

        return e(trim($this->format($doc, $doc->body, 0)));
    }

    public function preprocess(): string
    {
        $value = $this->context->get($this->params->get('field', 'content'));

        return e(json_encode($value->fieldtype()->preProcess($value->raw()), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function roundtrip(): string
    {
        $value = $this->context->get($this->params->get('field', 'content'));
        $fieldtype = $value->fieldtype();

        return e($fieldtype->process($fieldtype->preProcess($value->raw())));
    }

    protected function format(HTMLDocument $doc, Node $parent, int $depth): string
    {
        $output = '';
        foreach ($parent->childNodes as $node) {
            if ($node->nodeType === XML_TEXT_NODE && trim($node->textContent) === '') {
                continue;
            }
            $indent = str_repeat('    ', $depth);
            if (! $this->hasBlockChildren($node)) {
                $output .= $indent.$doc->saveHtml($node)."\n";

                continue;
            }
            $tag = strtolower($node->nodeName);
            $attrs = collect($node->attributes)->map(fn ($attr) => ' '.$attr->name.'="'.e($attr->value).'"')->implode('');
            $output .= "{$indent}<{$tag}{$attrs}>\n".$this->format($doc, $node, $depth + 1)."{$indent}</{$tag}>\n";
        }

        return $output;
    }

    protected function hasBlockChildren(Node $node): bool
    {
        foreach ($node->childNodes as $child) {
            if (in_array(strtolower($child->nodeName), $this->blocks)) {
                return true;
            }
        }

        return false;
    }
}
