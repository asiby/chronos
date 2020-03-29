<?php
namespace Chronos;

use Exception;
use Psr\Log\LoggerInterface;

class Chronos
{
    protected static $timeTrackers = [];

    /** @var LoggerInterface */
    protected static $logger = null;

    public static function setLogger(LoggerInterface $logger) {
        self::$logger = $logger;
    }

    /**
     * @param $label
     *
     * @throws Exception
     */
    private static function ensureTimerDoesExist($label) {
        if (!array_key_exists($label, self::$timeTrackers)) {
            throw new Exception("Timer '{$label}' does not exists");
        }
    }

    /**
     * @param $label
     *
     * @throws Exception
     */
    private static function ensureTimerDoesNotExist($label) {
        if (array_key_exists($label, self::$timeTrackers)) {
            throw new Exception("Timer '{$label}' already exists");
        }
    }

    /**
     * Start a new timer.
     *
     * @param string $label
     *
     * @throws Exception
     */
    public static function time($label = 'default') {
        self::ensureTimerDoesNotExist($label);

        self::$timeTrackers[$label] = microtime(true);
    }

    /**
     * Print the current timing information in the log and keep the timer active.
     *
     * @param string $label
     *
     * @throws Exception
     */
    public static function timeLog($label = 'default') {
        self::ensureTimerDoesExist($label);

        self::log("{$label}: " . (microtime(true) - self::$timeTrackers[$label]));
    }

    /**
     * Ends a timer and print the timing information in the log
     *
     * @param string $label
     *
     * @throws Exception
     */
    public static function timeEnd($label = 'default') {
        self::ensureTimerDoesExist($label);

        self::log("{$label}: " . (microtime(true) - self::$timeTrackers[$label]));

        unset(self::$timeTrackers[$label]);
    }

    /**
     * Outputs the timer's message.
     *
     * @param $message
     */
    private static function log($message) {
        if (self::$logger) {
            self::$logger->info($message);
        } else {
            error_log($message);
        }
    }
}
