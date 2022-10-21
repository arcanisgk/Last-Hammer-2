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
 * @note      This program is distributed in the hope that it will be useful.
 *            WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 *            or FITNESS FOR A PARTICULAR PURPOSE.
 */

declare(strict_types=1);

if (!version_compare(phpversion(), '8.1', '>=')) {
    die(sprintf("This project requires PHP ver. %s or higher", '8.1'));
}

require_once dirname(__DIR__) . '/vendor/autoload.php';

edo('1000.012', ['highlight' => true, 'detail' => true, 'end' => true]);
