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
                'blockquote'     => Nodes\Blockquote::class,
                'bold'           => Marks\Bold::class,
                'bulletList'     => Nodes\BulletList::class,
                'codeBlock'      => Nodes\CodeBlock::class,
                'code'           => Marks\Code::class,
                'hardBreak'      => Nodes\HardBreak::class,
                'heading'        => Nodes\Heading::class,
                'horizontalRule' => Nodes\HorizontalRule::class,
                'image'          => Nodes\Image::class,
                'italic'         => Marks\Italic::class,
                'link'           => Marks\Link::class,
                'listItem'       => Nodes\ListItem::class,
                'orderedList'    => Nodes\OrderedList::class,
                'paragraph'      => Nodes\Paragraph::class,
                'small'          => Marks\Small::class,
                'strike'         => Marks\Strike::class,
                'subscript'      => Marks\Subscript::class,
                'superscript'    => Marks\Superscript::class,
                'tableCell'      => Nodes\TableCell::class,
                'tableHeader'    => Nodes\TableHeader::class,
                'tableRow'       => Nodes\TableRow::class,
                'table'          => Nodes\Table::class,
                'underline'      => Marks\Underline::class,
            ]);
        });
    }
}
