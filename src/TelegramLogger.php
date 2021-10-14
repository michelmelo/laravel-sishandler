<?php

namespace MichelMelo\Logger;

use Monolog\Logger;

/**
 * Class SisLogger
 * @package App\Logging
 */
class SisLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return new Logger(
            config('app.name'),
            [
                new SisHandler($config['level']),
            ]
        );
    }
}
