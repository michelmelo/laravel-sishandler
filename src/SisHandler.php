<?php

namespace MichelMelo\Logger;

use Exception;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class SisHandler
 * @package App\Logging
 */
class SisHandler extends AbstractProcessingHandler
{
    /**
     * Bot API token
     *
     * @var string
     */
    private $botToken;

    /**
     * Chat id for bot
     *
     * @var int
     */
    private $chatId;

    /**
     * Application name
     *
     * @string
     */
    private $appName;

    /**
     * Application environment
     *
     * @string
     */
    private $appEnv;

    /**
     * SisHandler constructor.
     * @param int $level
     */
    public function __construct($level)
    {
        $level = Logger::toMonologLevel($level);

        parent::__construct($level, true);

        // define variables for making Telegram request
        $this->apiKey = config('sis-logger.apiKey');
        $this->apiURL = config('sis-logger.apiUrl');

        // define variables for text message
        $this->appName = config('app.name');
        $this->appEnv  = config('app.env');
    }

    /**
     * @param array $record
     */
    public function write(array $record): void
    {
        if (!$this->apiKey || !$this->apiURL) {
            return;
        }

        // trying to make request and send notification
        try {
            $dataSIS          = new \stdClass();
            $dataSIS->level   = $record['level'];
            $dataSIS->message = $record['message'];
            $dataSIS->context = $record;
            
            $dataSIS = json_encode($dataSIS);
            $url = $this->apiURL . '?appKey=' . $this->apiKey;
            $headers = ['Content-Type: application/json'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataSIS);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);

        } catch (Exception $exception) {

        }
    }


}
