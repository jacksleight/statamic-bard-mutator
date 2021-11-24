<?php

namespace JackSleight\StatamicBardMutator;

use Statamic\Statamic;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Fieldtypes\Bard\Augmentor;
use JackSleight\StatamicBardMutator\Mutator;
use JackSleight\StatamicBardMutator\Nodes;
use JackSleight\StatamicBardMutator\Marks;
use JackSleight\StatamicBardMutator\Facades;
use Statamic\Support\Arr;

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

        Statamic::booted(function () {
            $this->bootExtensions();
        });
    }
    
    protected function bootExtensions()
    {
        $types = Facades\Mutator::getMutatedTypes();

        $replacementNodes = [
            'blockquote'      => [\ProseMirrorToHtml\Nodes\Blockquote::class, Nodes\Blockquote::class],
            'bullet_list'     => [\ProseMirrorToHtml\Nodes\BulletList::class, Nodes\BulletList::class],
            'code_block'      => [\ProseMirrorToHtml\Nodes\CodeBlock::class, Nodes\CodeBlock::class],
            'hard_break'      => [\ProseMirrorToHtml\Nodes\HardBreak::class, Nodes\HardBreak::class],
            'heading'         => [\ProseMirrorToHtml\Nodes\Heading::class, Nodes\Heading::class],
            'horizontal_rule' => [\ProseMirrorToHtml\Nodes\HorizontalRule::class, Nodes\HorizontalRule::class],
            'image'           => [\Statamic\Fieldtypes\Bard\ImageNode::class, Nodes\Image::class],
            'list_item'       => [\ProseMirrorToHtml\Nodes\ListItem::class, Nodes\ListItem::class],
            'ordered_list'    => [\ProseMirrorToHtml\Nodes\OrderedList::class, Nodes\OrderedList::class],
            'paragraph'       => [\ProseMirrorToHtml\Nodes\Paragraph::class, Nodes\Paragraph::class],
            'table'           => [\ProseMirrorToHtml\Nodes\Table::class, Nodes\Table::class],
            'table_cell'      => [\ProseMirrorToHtml\Nodes\TableCell::class, Nodes\TableCell::class],
            'table_header'    => [\ProseMirrorToHtml\Nodes\TableHeader::class, Nodes\TableHeader::class],
            'table_row'       => [\ProseMirrorToHtml\Nodes\TableRow::class, Nodes\TableRow::class],
        ];
        $replacementMarks = [
            'bold'        => [\ProseMirrorToHtml\Marks\Bold::class, Marks\Bold::class],
            'code'        => [\ProseMirrorToHtml\Marks\Code::class, Marks\Code::class],
            'italic'      => [\ProseMirrorToHtml\Marks\Italic::class, Marks\Italic::class],
            'link'        => [\Statamic\Fieldtypes\Bard\LinkMark::class, Marks\Link::class],
            'subscript'   => [\ProseMirrorToHtml\Marks\Subscript::class, Marks\Subscript::class],
            'underline'   => [\ProseMirrorToHtml\Marks\Underline::class, Marks\Underline::class],
            'strike'      => [\ProseMirrorToHtml\Marks\Strike::class, Marks\Strike::class],
            'superscript' => [\ProseMirrorToHtml\Marks\Superscript::class, Marks\Superscript::class],
        ];

        $replaceNodes = Arr::only($replacementNodes, $types);
        $replaceMarks = Arr::only($replacementMarks, $types);

        foreach ($replaceNodes as $searchNode => $mutatorNode) {
            Augmentor::replaceNode($searchNode, $mutatorNode);
        }
        foreach ($replaceMarks as $searchMark => $mutatorMark) {
            Augmentor::replaceMark($searchMark, $mutatorMark);
        }
    }
}
