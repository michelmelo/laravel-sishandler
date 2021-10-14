<?php

namespace MichelMelo\Logger;

use Illuminate\Support\ServiceProvider;

/**
 * Class SisLoggerServiceProvider
 * @package Logger
 */
class SisLoggerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sis-logger.php', 'sis-logger');
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/sis-logger.php' => config_path('sis-logger.php')], 'config');
    }
}
