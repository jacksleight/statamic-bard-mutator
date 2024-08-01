<?php

namespace JackSleight\StatamicBardMutator;

use JackSleight\StatamicBardMutator\Facades\Mutator as MutatorFacade;
use Statamic\Fieldtypes\Bard;
use Statamic\Fieldtypes\Bard\Augmentor;
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
        $this
            ->bootExtensions()
            ->bootHooks()
            ->bootFields();
    }

    protected function bootExtensions()
    {
        Augmentor::addExtensions([
            'bmuRoot' => function ($bard) {
                return new Nodes\Root(['bard' => $bard->field()]);
            },
            'bmuHtml' => new Nodes\Html(),
        ]);

        $this->app->booted(function () {
            MutatorFacade::registerExtensions();
        });

        return $this;
    }

    protected function bootHooks()
    {
        Bard::hook('augment', function ($value, $next) {
            return $next(MutatorFacade::injectRoot($value));
        });

        return $this;
    }

    protected function bootFields()
    {
        $this->app->booted(function () {
            $options = collect(MutatorFacade::selectablePlugins())
                ->mapWithKeys(fn ($plugin) => [$plugin->handle() => $plugin->display()])
                ->all();
            if (! count($options)) {
                return $this;
            }

            Bard::appendConfigField('bmu_plugins', [
                'display' => __('Mutator Plugins'),
                'instructions' => 'Which plugins to run on this field. Global plugins run on all fields.',
                'type' => 'select',
                'multiple' => true,
                'options' => $options,
            ]);
        });

        return $this;
    }
}
