<?php

namespace JackSleight\StatamicBardMutator;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        __DIR__.'/../dist/js/addon.js',
    ];

    protected $tags = [
        Tags\MutatorTag::class,
    ];

    public function register()
    {
        parent::register();

        $this->app->singleton(Mutator::class, function () {
            return new Mutator([
                'blockquote'      => Nodes\Blockquote::class,
                'bold'            => Marks\Bold::class,
                'bullet-list'     => Nodes\BulletList::class,
                'code-block'      => Nodes\CodeBlock::class,
                'code'            => Marks\Code::class,
                'hard-break'      => Nodes\HardBreak::class,
                'heading'         => Nodes\Heading::class,
                'horizontal-rule' => Nodes\HorizontalRule::class,
                'image'           => Nodes\Image::class,
                'italic'          => Marks\Italic::class,
                'link'            => Marks\Link::class,
                'list-item'       => Nodes\ListItem::class,
                'ordered-list'    => Nodes\OrderedList::class,
                'paragraph'       => Nodes\Paragraph::class,
                'small'           => Marks\Small::class,
                'strike'          => Marks\Strike::class,
                'subscript'       => Marks\Subscript::class,
                'superscript'     => Marks\Superscript::class,
                'table-cell'      => Nodes\TableCell::class,
                'table-header'    => Nodes\TableHeader::class,
                'table-row'       => Nodes\TableRow::class,
                'table'           => Nodes\Table::class,
                'underline'       => Marks\Underline::class,
            ]);
        });
    }
}
