<?php

namespace JackSleight\StatamicBardMutator;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            \Tiptap\Editor::class,
            \JackSleight\StatamicBardMutator\Editor::class
        );
    }
}
