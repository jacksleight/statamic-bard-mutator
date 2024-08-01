<?php

namespace Tests;

use JackSleight\StatamicBardMutator\Facades\Mutator;
use JackSleight\StatamicBardMutator\ServiceProvider;
use Statamic\Fields\Field;
use Statamic\Fields\Value;
use Statamic\Fieldtypes\Bard\Augmentor;
use Statamic\Testing\AddonTestCase;

class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;

    protected $nodes = [
        'blockquote' => [],
        'bulletList' => [],
        'codeBlock' => [],
        'hardBreak' => [],
        'heading' => ['level' => 1],
        'horizontalRule' => [],
        'image' => ['src' => 'test.jpg'],
        'listItem' => [],
        'orderedList' => [],
        'paragraph' => [],
        'tableCell' => [],
        'tableHeader' => [],
        'tableRow' => [],
        'table' => [],
    ];

    protected $marks = [
        'bold' => [],
        'code' => [],
        'italic' => [],
        'link' => ['href' => '#'],
        'small' => [],
        'strike' => [],
        'subscript' => [],
        'superscript' => [],
        'underline' => [],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        Mutator::registerAllExtensions();
    }

    protected function getTestNode($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type' => $type,
            'attrs' => $attrs ? $attrs : null,
        ]]);
    }

    protected function getTestMark($type, $attrs = [])
    {
        return $this->getTestValue([[
            'type' => 'text',
            'marks' => [[
                'type' => $type,
                'attrs' => $attrs ? $attrs : null,
            ]],
        ]]);
    }

    protected function getTestValue($value, $config = [])
    {
        return new Value($value, 'handle', $this->getTestField($config)->fieldtype());
    }

    protected function getTestField($config = [])
    {
        return new Field('handle', ['type' => 'bard'] + $config);
    }

    protected function renderTestValue(Value $value)
    {
        return (new Augmentor($value->fieldtype()))->augment($value->raw());
    }
}
