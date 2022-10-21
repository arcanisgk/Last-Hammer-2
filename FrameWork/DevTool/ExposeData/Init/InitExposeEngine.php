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

use ArcanisGK\LastHammer2\FrameWork\DevTool\ExposeData\ExposeEngine;

/**
 * @param ...$data
 * @return void
 */

function ed(...$data): void
{
    foreach ($data as $var) {
        ExposeEngine::getInstance()
            ->varDump($var);
    }
}

/**
 * @param ...$data
 * @return void
 */

function edd(...$data): void
{
    foreach ($data as $var) {
        ExposeEngine::getInstance()
            ->setOption([
                'highlight' => true,
                'detail' => true,
                'end' => false,
                'return' => true,
            ])
            ->varDump($var);
    }
}

/**
 * @param $data
 * @param array $option
 * @return void
 */

function edo($data, array $option): void
{
    $expose = new ExposeEngine();
    $expose
        ->setOption($option)
        ->varDump($data);
}
