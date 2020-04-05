<?php
namespace ASiby;

use Exception;
use Psr\Log\LoggerInterface;

class Chronos
{
    protected static $timeTrackers = [];
    protected static $decimalPrecision = 10;
    protected static $defaultLabel = 'default';

    /** @var LoggerInterface */
    protected static $logger = null;

    /** @noinspection PhpUnused */
    public static function setLogger(LoggerInterface $logger) {
        self::$logger = $logger;
    }

    /**
     * @return int
     * @noinspection PhpUnused
     */
    public static function getDecimalPrecision(): int
    {
        return self::$decimalPrecision;
    }

    /**
     * @param int $decimalPrecision
     * @noinspection PhpUnused*/
    public static function setDecimalPrecision(int $decimalPrecision): void
    {
        self::$decimalPrecision = $decimalPrecision;
    }

    /**
     * @param $label
     *
     * @throws Exception
     */
    private static function ensureTimerDoesExist($label) {
        if (!array_key_exists($label, self::$timeTrackers)) {
            throw new Exception("Timer '{$label}' does not exists", 400);
        }
    }

    /**
     * @param $label
     *
     * @throws Exception
     */
    private static function ensureTimerDoesNotExist($label) {
        if (array_key_exists($label, self::$timeTrackers)) {
            throw new Exception("Timer '{$label}' already exists", 400);
        }
    }

    /**
     * Start a new timer.
     *
     * @param string $label
     * @param bool   $verbose
     */
    public static function time($label = 'default', $verbose = false) {
        $label = self::sanitizeLabel($label);

        try
        {
            self::ensureTimerDoesNotExist($label);
        } catch (Exception $exception) {
            self::log("{$exception->getMessage()} (code {$exception->getCode()})");
            return;
        }

        $now = microtime(true);

        self::$timeTrackers[$label] = [
            'startTime' => $now,
            'lastLogTime' => null,
            'verbose' => $verbose,
        ];

        if ($verbose) {
            self::log("Started a new timer with the label '{$label}'");
        }
    }

    /**
     * Print the current timing information in the log and keep the timer active.
     *
     * @param string $label
     * @param string $description
     * @param bool   $showDelta
     */
    public static function logTime($label = 'default', $description = null, $showDelta = true) {
        $label = self::sanitizeLabel($label);

        try
        {
            self::ensureTimerDoesExist($label);
        } catch (Exception $exception) {
            self::log("{$exception->getMessage()} (code {$exception->getCode()})");
            return;
        }

        $now = microtime(true);
        $timeLog = self::format($now - self::$timeTrackers[$label]['startTime']);
        $timeLogDelta = self::format($now - (self::$timeTrackers[$label]['lastLogTime'] ?? 0));

        $message = '';

        $message .= "{$label}: {$timeLog}";

        if (self::$timeTrackers[$label]['lastLogTime'] ?? false) {
            if ($showDelta) {
                $message .= " - Time log delta: {$timeLogDelta}";
            }
        }

        if ($description) {
            $message .= " - {$description}";
        }

        self::log($message);

        self::$timeTrackers[$label]['lastLogTime'] = $now;
    }

    /**
     * Alias for static::logTime()
     *
     * @param string $label
     * @param null   $description
     * @param bool   $showDelta
     */
    public static function timeLog($label = 'default', $description = null, $showDelta = true) {
        self::logTime($label, $description, $showDelta);
    }

    /**
     * Ends a timer and print the timing information in the log
     *
     * @param string $label
     * @param string $description
     */
    public static function endTime($label = 'default', $description = '') {
        $label = self::sanitizeLabel($label);

        try
        {
            self::ensureTimerDoesExist($label);
        } catch (Exception$exception) {
            self::log("{$exception->getMessage()} (code {$exception->getCode()})");
            return;
        }

        $now = microtime(true);
        $timeLog = self::format($now - self::$timeTrackers[$label]['startTime']);

        $message = '';

//        if (self::$timeTrackers[$label]['verbose']) {
//            $message = "Line #" . __LINE__ . " - ";
//        }

        $message .= "{$label}: {$timeLog}";

        if ($description) {
            $message .= " - {$description}";
        }

        if (self::$timeTrackers[$label]['verbose']) {
            $message = "{$message} (final)";
        }

        self::log($message);

        if (self::$timeTrackers[$label]['verbose']) {
            self::log("Terminated the timer with the label '{$label}'");
        }

        unset(self::$timeTrackers[$label]);
    }

    /**
     * Alias for static::endTime()
     *
     * @param string $label
     * @param string $description
     */
    public static function timeEnd($label = 'default', $description = '') {
        self::endTime($label, $description);
    }

    /**
     * Format the timer times.
     *
     * @param      $number
     * @param int  $decimals
     *
     * @param bool $withUnit
     *
     * @return string
     */
    private static function format($number, $decimals = null, $withUnit = true) {
        return number_format($number, (int) ($decimals ?? self::$decimalPrecision)) . ($withUnit ? 's' : '');
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

    private static function sanitizeLabel(string $label = null)
    {
        return $label ?? self::$defaultLabel;
    }
}
