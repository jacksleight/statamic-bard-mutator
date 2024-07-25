<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator as MutatorFacade;
use Statamic\Fieldtypes\Bard;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->singleton(Mutator::class, function () {
            return new Mutator([
                'blockquote' => new Nodes\Blockquote(),
                'bold' => new Marks\Bold(),
                'bulletList' => new Nodes\BulletList(),
                'codeBlock' => new Nodes\CodeBlock(),
                'code' => new Marks\Code(),
                'hardBreak' => new Nodes\HardBreak(),
                'heading' => new Nodes\Heading(),
                'horizontalRule' => new Nodes\HorizontalRule(),
                'image' => function ($extension, $bard, $options) {
                    return $options['withStatamicImageUrls']
                        ? new Nodes\StatamicImage
                        : new Nodes\Image;
                },
                'italic' => new Marks\Italic(),
                'link' => function ($extension, $bard, $options) {
                    return $options['withStatamicImageUrls']
                        ? new Marks\StatamicLink
                        : new Marks\Link;
                },
                'listItem' => new Nodes\ListItem(),
                'orderedList' => new Nodes\OrderedList(),
                'paragraph' => new Nodes\Paragraph(),
                'small' => new Marks\Small(),
                'strike' => new Marks\Strike(),
                'subscript' => new Marks\Subscript(),
                'superscript' => new Marks\Superscript(),
                'tableCell' => new Nodes\TableCell(),
                'tableHeader' => new Nodes\TableHeader(),
                'tableRow' => new Nodes\TableRow(),
                'table' => new Nodes\Table(),
                'underline' => new Marks\Underline(),
            ]);
        });
    }

    public function bootAddon()
    {
        Bard::hook('augment', function ($value, $next) {
            return $next(MutatorFacade::injectRoot($value));
        });
    }
}
