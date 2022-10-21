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

namespace ArcanisGK\LastHammer2\FrameWork\Common;

/**
 * Description: Class ClDetector.
 * @package ArcanisGK\LastHammer2\FrameWork
 */
class ClDetector
{
    /**
     * @var ClDetector|null
     */

    private static ?ClDetector $instance = null;

    /**
     * Description: constant sets the 'CLI' string
     * @const string
     */

    private const ENV_CLI = 'CLI';

    /**
     * Description: constant sets the 'WEB' string
     * @const string
     */

    private const ENV_WEB = 'WEB';

    /**
     * Description: Auto-Instance Helper for static development class BugCatcher.
     * @return ClDetector
     */

    public static function getInstance(): ClDetector
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Description: environment description.
     *  - CLI
     *  - WEB
     * @var string
     */

    private string $environment;

    /**
     * Description: construct of class
     */

    public function __construct()
    {
        //echo 'Hello World ClDetector<br>';
        $this->setEnvironment($this->evaluateEnvironment() ? $this::ENV_CLI : $this::ENV_WEB);
    }

    /**
     * Description: setter of environment
     * @param string $environment
     */

    private function setEnvironment(string $environment): void
    {
        $this->environment = $environment;
    }

    /**
     * Description: Determinate if Running from Terminal/Command-Line Environment or Web by default.
     * @return bool
     */

    private function evaluateEnvironment(): bool
    {
        return defined('STDIN')
            || php_sapi_name() === "cli"
            || (stristr(PHP_SAPI, 'cgi') && getenv('TERM'))
            || (empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0);
    }

    /**
     * Description: Validation of CLI Environment.
     * @return bool
     */

    public function isCLI(): bool
    {
        return ($this->getEnvironment() === $this::ENV_CLI);
    }

    /**
     * Description: Returns the string of the environment in which the current execution is located.
     * @return string
     */

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Description: Validation of WEB Environment.
     * @return bool
     */

    public function isWEB(): bool
    {
        return ($this->getEnvironment() === $this::ENV_WEB);
    }
}