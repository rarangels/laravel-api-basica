<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 6/07/20
 * Time: 12:26 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica\Traits;

/**
 * Trait customSearches
 *
 * @package App\Traits
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
trait customSearches
{
    /**
     * @param $keyword
     * @param $arrayToSearch
     * @return int|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function findKeyBySubstringInValue($keyword, $arrayToSearch)
    {
        foreach ($arrayToSearch as $key => $arrayItem) {
            if (stristr($arrayItem, $keyword)) {
                return $key;
            }
        }
    }

    /**
     * @param $instance
     * @param $arrayToSearch
     * @return int|string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function findKeyByInstanceInValue($instance, $arrayToSearch)
    {
        foreach ($arrayToSearch as $key => $arrayItem) {
            if ($arrayItem instanceof $instance) {
                return $key;
            }
        }
    }
}
