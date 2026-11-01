<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        foreach (['Tests', 'Demos'] as $folder) {
            foreach (glob(app_path("Mutator/{$folder}/*.php")) as $file) {
                require $file;
            }
        }
    }
}
