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
 * @note      This program is distributed in the hope that it will be useful
 *            WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 *            or FITNESS FOR A PARTICULAR PURPOSE.
 */

declare(strict_types=1);

namespace ArcanisGK\LastHammer2\FrameWork\DevTool\Error\Init;

use ArcanisGK\LastHammer2\FrameWork\Common\ClDetector;
use ArcanisGK\LastHammer2\FrameWork\DevTool\Error\BugCatcher;
use JetBrains\PhpStorm\NoReturn;

/**
 * Description: Class InitDevTool.
 * @package ArcanisGK\LastHammer2\FrameWork
 */
class InitDevTool
{

    /**
     * @var InitDevTool|null
     */

    private static ?InitDevTool $instance = null;

    /**
     * Description: Auto-Instance Helper for static development class phpDevToolInitialization.
     * @return InitDevTool
     */

    public static function getInstance(): InitDevTool
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Description: Initializes the tools of the PhpDevelopmentTool class
     * @return void
     */

    public function directiveValidator(): void
    {
        if (ClDetector::getInstance()->isWEB()) {
            $directive = [];
            require_once dirname(__DIR__) . '/Init/directive.php';
            $htaccess_error = false;
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/.htaccess')) {
                $htaccess_error = true;
            } elseif (!str_contains(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/.htaccess'), 'BugCatcher')) {
                $htaccess_error = true;
            }
            if ($htaccess_error === true) {
                $dir_reader = file_get_contents(dirname(__DIR__) . '/Init/htaccess.txt');
                $directive['htaccess']['config'] = str_replace("{{config}}", highlight_string($dir_reader, true), $directive['htaccess']['config']);
                $this->renderTemplate($directive['htaccess']['config']);
            }
            $user_error = false;
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/.user.ini')) {
                $user_error = true;
            } elseif (!str_contains(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/.user.ini'), 'BugCatcher')) {
                $user_error = true;
            }
            if ($user_error === true) {
                $dir_reader = file_get_contents(dirname(__DIR__) . '/Init/user.txt');
                $directive['user']['config'] = str_replace("{{config}}", highlight_string($dir_reader, true), $directive['user']['config']);
                $this->renderTemplate($directive['user']['config']);
            }
        }
    }

    /**
     * @param $directive_explained
     * @return void
     */

    #[NoReturn] private function renderTemplate($directive_explained): void
    {
        $template_reader = file_get_contents(dirname(__DIR__) . '/Init/template.html');
        $instruction = str_replace("{{explain}}", $directive_explained, $template_reader);
        echo $instruction;
        exit();
    }
}

ob_start();
InitDevTool::getInstance()->directiveValidator();
BugCatcher::getInstance();