<?php

/**
 * Last Hammer 2.
 * PHP Version required 8.1 or higher
 *
 * @see https://github.com/arcanisgk/Last-Hammer-2
 *
 * @author    Walter Nuñez (arcanisgk/original founder)
 * @email     icarosnet@gmail.com
 * @copyright 2020 - 2022 Walter Nuñez/Icaros Net S.A.
 * @licence   For the full copyright and licence information, please view the LICENCE.
 * @note      This program is distributed in the hope it will be useful
 *            WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 *            or FITNESS FOR A PARTICULAR PURPOSE.
 */

declare(strict_types=1);

namespace ArcanisGK\LastHammer2\FrameWork\DevTool\Error;

use ArcanisGK\LastHammer2\FrameWork\Common\ClDetector;
use ArcanisGK\LastHammer2\FrameWork\Common\ClOutput;
use ArcanisGK\LastHammer2\FrameWork\Common\Request;
use JetBrains\PhpStorm\NoReturn;

/**
 * Description: Class BugCatcher.
 * @package ArcanisGK\LastHammer2\FrameWork
 */
class BugCatcher
{
    /**
     * @var BugCatcher|null
     */

    private static ?BugCatcher $instance = null;

    /**
     * @var string
     */

    private string $line_separator;

    /**
     * @var bool
     */

    private bool $display_error;

    /**
     * @var bool
     */

    private bool $to_log;

    /**
     * Description: this class is armed automatically now it is instantiated and remains active.
     */

    public function __construct()
    {
        $this->setLineSeparator($this->detectLineSeparator());
        $this->setDisplayError($this->isDisplayErrors());
        $this->setToLog($this->isDisplayErrors());
        register_shutdown_function([$this, "shutdownHandler"]);
        set_exception_handler([$this, "exceptionHandler"]);
        set_error_handler([$this, "errorHandler"]);
    }

    /**
     * @param string $line_separator
     */

    private function setLineSeparator(string $line_separator): void
    {
        $this->line_separator = $line_separator;
    }

    /**
     * @return string
     */

    private function detectLineSeparator(): string
    {
        return ClDetector::getInstance()->isCLI() ? PHP_EOL : '<br>';
    }

    /**
     * Description: Auto-Instance Helper for static development class BugCatcher.
     * @return BugCatcher
     */

    public static function getInstance(): BugCatcher
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param bool $display_error
     */

    private function setDisplayError(bool $display_error): void
    {
        $this->display_error = $display_error;
    }

    /**
     * @return bool
     */

    private function isDisplayErrors(): bool
    {
        return ini_get('display_errors') == 1;
    }

    /**
     * @param bool $to_log
     */

    private function setToLog(bool $to_log): void
    {
        $this->to_log = $to_log;
    }

    /**
     * @return void
     */

    public function shutdownHandler(): void
    {
        $error = error_get_last();
        if (!is_null($error)) {
            $this->cleanOutput();
            $trace = array_reverse(debug_backtrace());
            array_pop($trace);
            $error_array = [
                'class' => 'ShutdownHandler',
                'type' => $error['type'],
                'description' => $error['message'],
                'file' => $error['file'],
                'line' => $error['line'],
                'trace' => $trace,
            ];
            $error_array['trace_msg'] = $this->getBacktrace($error_array);
            $this->output($error_array);
        }
    }

    /**
     * @return void
     */

    private function cleanOutput(): void
    {
        if (ob_get_contents() || ob_get_length()) {
            ob_end_clean();
            flush();
        }
    }

    /**
     * @param array $error_array
     * @return string
     */

    private function getBacktrace(array $error_array): string
    {
        $smg = [];
        if (!empty($error_array['trace'])) {
            foreach ($error_array['trace'] as $track) {
                if (!isset($track['file']) && !isset($track['line'])) {
                    $route = 'Magic Call Method: (' . $track['class'] . ')->';
                } else {
                    $route = $track['file'] . ' ' . $track['line'] . ' calling Method: ';
                }
                $smg[] = '  ' . $route . $track['function'] . '()';
            }
        } else {
            $smg[] = 'No backtrace data in the ' . $error_array['class'] . '.';
        }

        return implode($this->getLineSeparator(), $smg);
    }

    /**
     * @return string
     */

    private function getLineSeparator(): string
    {
        return $this->line_separator;
    }

    /**
     * @param array $error_array
     * @return void
     */

    #[NoReturn] private function output(array $error_array): void
    {
        $this->toLog($error_array);

        $rqType = Request::getInstance()->getRequestType();

        if (ClDetector::getInstance()->isCLI()) {
            ClOutput::getInstance()->cliOutputError($error_array);
        } elseif ($rqType == 'plain') {
            $error_skin = dirname(__DIR__) . '/Error/template/handler_error.php';
            $source = show_source(
                $error_array['file'],
                true
            );
            require_once $error_skin;
        } else {
            header('Content-Type: application/json');
            echo json_encode($error_array);
        }
        $this->clearLastError();
    }

    /**
     * @param array $error_array
     * @return void
     */

    private function toLog(array $error_array): void
    {
        $trace = preg_replace("/\r|\n|\r\n/", "", $error_array['trace_msg']);

        $error_smg_log = time() . ' ' .
            date(
                'Y-m-d H:i:s'
            ) . ' ' . $error_array['description'] .
            ' Trace: ' . $trace . PHP_EOL;

        error_log($error_smg_log, 3, '../log/error_log.log');
    }

    /**
     * @return void
     */

    #[NoReturn] private function clearLastError(): void
    {
        error_clear_last();
        exit();
    }

    /**
     * @param $e
     * @return void
     */

    #[NoReturn] public function exceptionHandler($e): void
    {
        $this->cleanOutput();
        $error_array = [
            'class' => 'ExceptionHandler',
            'type' => ($e->getCode() == 0 ? 'Not Set' : $e->getCode()),
            'description' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace(),
        ];
        $error_array['trace_msg'] = $this->getBacktrace($error_array);
        $this->output($error_array);
        die();
    }

    /**
     * @param $error_level
     * @param $error_desc
     * @param $error_file
     * @param $error_line
     * @return void
     */

    #[NoReturn] public function errorHandler(
        $error_level = null,
        $error_desc = null,
        $error_file = null,
        $error_line = null
    ): void {
        $this->cleanOutput();
        $trace = array_reverse(debug_backtrace());
        array_pop($trace);
        $error_array = [
            'class' => 'ErrorHandler',
            'type' => $error_level,
            'description' => $error_desc,
            'file' => $error_file,
            'line' => $error_line,
            'trace' => $trace,
        ];
        $error_array['trace_msg'] = $this->getBacktrace($error_array);
        $this->output($error_array);
    }

    /**
     * @return bool
     */

    private function getDisplayError(): bool
    {
        return $this->display_error;
    }

    /**
     * @return bool
     */

    private function getToLog(): bool
    {
        return $this->to_log;
    }
}

