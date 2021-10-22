<?php

namespace JackSleight\StatamicBardMutator;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Fieldtypes\Bard\Augmentor;
use JackSleight\StatamicBardMutator\Mutator;
use JackSleight\StatamicBardMutator\Nodes;
use JackSleight\StatamicBardMutator\Marks;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        parent::register();
        
        $this->app->singleton(Mutator::class, function () {
            return new Mutator();
        });
    }
    
    public function boot()
    {
        parent::boot();

        $classes = [
            'replaceNodes' => [
                \ProseMirrorToHtml\Nodes\Blockquote::class       => Nodes\Blockquote::class,
                \ProseMirrorToHtml\Nodes\BulletList::class       => Nodes\BulletList::class,
                \ProseMirrorToHtml\Nodes\CodeBlock::class        => Nodes\CodeBlock::class,
                \ProseMirrorToHtml\Nodes\HardBreak::class        => Nodes\HardBreak::class,
                \ProseMirrorToHtml\Nodes\Heading::class          => Nodes\Heading::class,
                \ProseMirrorToHtml\Nodes\HorizontalRule::class   => Nodes\HorizontalRule::class,
                \Statamic\Fieldtypes\Bard\ImageNode::class       => Nodes\Image::class,
                \ProseMirrorToHtml\Nodes\ListItem::class         => Nodes\ListItem::class,
                \ProseMirrorToHtml\Nodes\OrderedList::class      => Nodes\OrderedList::class,
                \ProseMirrorToHtml\Nodes\Paragraph::class        => Nodes\Paragraph::class,
                \ProseMirrorToHtml\Nodes\Table::class            => Nodes\Table::class,
                \ProseMirrorToHtml\Nodes\TableCell::class        => Nodes\TableCell::class,
                \ProseMirrorToHtml\Nodes\TableHeader::class      => Nodes\TableHeader::class,
                \ProseMirrorToHtml\Nodes\TableRow::class         => Nodes\TableRow::class,
            ],
            'replaceMarks' => [
                \ProseMirrorToHtml\Marks\Bold::class             => Marks\Bold::class,
                \ProseMirrorToHtml\Marks\Code::class             => Marks\Code::class,
                \ProseMirrorToHtml\Marks\Italic::class           => Marks\Italic::class,
                \Statamic\Fieldtypes\Bard\LinkMark::class        => Marks\Link::class,
                \ProseMirrorToHtml\Marks\Subscript::class        => Marks\Subscript::class,
                \ProseMirrorToHtml\Marks\Underline::class        => Marks\Underline::class,
                \ProseMirrorToHtml\Marks\Strike::class           => Marks\Strike::class,
                \ProseMirrorToHtml\Marks\Superscript::class      => Marks\Superscript::class,
            ],
        ];
        foreach ($classes['replaceNodes'] as $searchNode => $mutatorNode) {
            Augmentor::replaceNode($searchNode, $mutatorNode);
        }
        foreach ($classes['replaceMarks'] as $searchMark => $mutatorMark) {
            Augmentor::replaceMark($searchMark, $mutatorMark);
        }
    }
}
