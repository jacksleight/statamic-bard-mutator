<?php

namespace JackSleight\BardMutator;

use Statamic\Providers\AddonServiceProvider;
use Statamic\Fieldtypes\Bard\Augmentor;
use JackSleight\BardMutator\Mutator;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/bard-mutator.php', 'bard-mutator',
        );
        
        $this->app->singleton(Mutator::class, function () {
            return new Mutator();
        });
    }
    
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/bard-mutator.php' => config_path('bard-mutator.php'),
        ], 'bard-mutator-config');

        foreach (config('bard-mutator.replace_nodes') as $searchNode => $mutatorNode) {
            Augmentor::replaceNode($searchNode, $mutatorNode);
        }
        foreach (config('bard-mutator.replace_marks') as $searchMark => $mutatorMark) {
            Augmentor::replaceMark($searchMark, $mutatorMark);
        }
    }
}
