<?php

namespace Bhanwarpsrathore\PdfProcessor;

use Illuminate\Support\ServiceProvider;

class PdfProcessorServiceProvider extends ServiceProvider {
    public function boot(): void {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/config.php' => config_path('pdf-processor.php')], 'config');
        }
    }

    public function register(): void {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'pdf-processor');
    }
}
