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

namespace ArcanisGK\LastHammer2\FrameWork\DevTool\ExposeData;

/**
 * Description: Class ExposeEngine.
 * @package ArcanisGK\LastHammer2\FrameWork
 */
class ExposeEngine
{
    /**
     * @var ExposeEngine|null
     */

    private static ?ExposeEngine $instance = null;

    /**
     * @return ExposeEngine
     */

    public static function getInstance(): ExposeEngine
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Description: You can use this method to add or manipulate the display options that will handle your data.
     * @param array $options
     * <pre>
     *  1. 'highlight' => false, // (boolean) Expected to on/off highlight default off (false).
     *  2. 'detail' => false, // (boolean) Expected to on/off detail variable/node default off (false).
     *  3. 'end' => false, // (boolean) Expected to on/off to exitScript execution default off (false).
     * </pre>
     * @return $this
     */
    public function setOption(array $options = []): ExposeEngine
    {
        /*
        if (!empty($options)) {
            $this->setHighlight(
                isset($options['highlight']) && ($options['highlight'] == true || $options['highlight'] == 'true')
            );

            $this->setDetail(
                isset($options['detail']) && ($options['detail'] == true || $options['detail'] == 'true')
            );

            $this->setEnd(
                isset($options['end']) && ($options['end'] == true || $options['end'] == 'true')
            );

            $this->setReturn(
                isset($options['return']) && ($options['return'] == true || $options['return'] == 'true')
            );
        }
        */
        return $this;
    }

    /**
     * @param $data
     * @return void
     */
    public function varDump($data): void
    {
        var_dump($data);
        //echo 'Hello World';
    }
}