<?php

return [

    'replace_nodes' => [
        ProseMirrorToHtml\Nodes\Blockquote::class       => JackSleight\BardMutator\Nodes\Blockquote::class,
        ProseMirrorToHtml\Nodes\BulletList::class       => JackSleight\BardMutator\Nodes\BulletList::class,
        ProseMirrorToHtml\Nodes\CodeBlock::class        => JackSleight\BardMutator\Nodes\CodeBlock::class,
        ProseMirrorToHtml\Nodes\HardBreak::class        => JackSleight\BardMutator\Nodes\HardBreak::class,
        ProseMirrorToHtml\Nodes\Heading::class          => JackSleight\BardMutator\Nodes\Heading::class,
        ProseMirrorToHtml\Nodes\HorizontalRule::class   => JackSleight\BardMutator\Nodes\HorizontalRule::class,
        Statamic\Fieldtypes\Bard\ImageNode::class       => JackSleight\BardMutator\Nodes\Image::class,
        ProseMirrorToHtml\Nodes\ListItem::class         => JackSleight\BardMutator\Nodes\ListItem::class,
        ProseMirrorToHtml\Nodes\OrderedList::class      => JackSleight\BardMutator\Nodes\OrderedList::class,
        ProseMirrorToHtml\Nodes\Paragraph::class        => JackSleight\BardMutator\Nodes\Paragraph::class,
        ProseMirrorToHtml\Nodes\Table::class            => JackSleight\BardMutator\Nodes\Table::class,
        ProseMirrorToHtml\Nodes\TableCell::class        => JackSleight\BardMutator\Nodes\TableCell::class,
        ProseMirrorToHtml\Nodes\TableHeader::class      => JackSleight\BardMutator\Nodes\TableHeader::class,
        ProseMirrorToHtml\Nodes\TableRow::class         => JackSleight\BardMutator\Nodes\TableRow::class,
    ],

    'replace_marks' => [
        ProseMirrorToHtml\Marks\Bold::class             => JackSleight\BardMutator\Marks\Bold::class,
        ProseMirrorToHtml\Marks\Code::class             => JackSleight\BardMutator\Marks\Code::class,
        ProseMirrorToHtml\Marks\Italic::class           => JackSleight\BardMutator\Marks\Italic::class,
        Statamic\Fieldtypes\Bard\LinkMark::class        => JackSleight\BardMutator\Marks\Link::class,
        ProseMirrorToHtml\Marks\Subscript::class        => JackSleight\BardMutator\Marks\Subscript::class,
        ProseMirrorToHtml\Marks\Underline::class        => JackSleight\BardMutator\Marks\Underline::class,
        ProseMirrorToHtml\Marks\Strike::class           => JackSleight\BardMutator\Marks\Strike::class,
        ProseMirrorToHtml\Marks\Superscript::class      => JackSleight\BardMutator\Marks\Superscript::class,
    ],

];
