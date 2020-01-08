<?php

declare(strict_types=1);

namespace Test\CQApi;


use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class StdoutHandler
 * @package Test\CQApi
 */
class StdoutHandler extends StreamHandler
{
    const FORMAT = "[%datetime%] [%level_name%] %message% %context% %extra%\n";

    /**
     * StdoutHandler constructor.
     * @param int $level
     * @param bool $bubble
     * @param int|null $filePermission
     * @param bool $useLocking
     * @throws \Exception
     */
    public function __construct($level = Logger::DEBUG, bool $bubble = true, ?int $filePermission = null, bool $useLocking = false)
    {
        parent::__construct('php://stdout', $level, $bubble, $filePermission, $useLocking);
    }

    /**
     * @return FormatterInterface
     */
    public function getDefaultFormatter(): FormatterInterface
    {
        return new LineFormatter(self::FORMAT);
    }
}