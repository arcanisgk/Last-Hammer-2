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
 * Description: Class Request.
 * @package ArcanisGK\LastHammer2\FrameWork
 */
class Request
{
    /**
     * @var Request|null
     */

    private static ?Request $instance = null;

    /**
     * Description: Auto-Instance Helper for static development class BugCatcher.
     * @return Request
     */

    public static function getInstance(): Request
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return string
     */

    public function getRequestType(): string
    {
        $var = $_GET ?? $_POST;
        if ((isset($_POST) || isset($_GET)) && !empty($var)) {
            if (count($var) >= 1) {
                return $this->isJson($var) ? 'json' : 'plain';
            }
        }

        return 'plain';
    }

    /**
     * @param array $var
     * @return bool
     */

    private function isJson(array $var): bool
    {
        $var = reset($var);
        if (is_string($var)) {
            json_decode($var);
        }

        return json_last_error() === JSON_ERROR_NONE;
    }


}