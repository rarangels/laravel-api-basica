<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 29/07/20
 * Time: 5:54 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica\Traits;

/**
 * Trait timeToText
 *
 * @package App\Traits
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
trait timeToText
{
    /**
     * @param $segundos
     * @return string
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function fromSeg($segundos)
    {
        $dias = floor($segundos / 86400);
        $mod_hora = $segundos % 86400;
        $horas = floor($mod_hora / 3600);
        $mod_minuto = $mod_hora % 3600;
        $minutos = floor($mod_minuto / 60);

        $segundos = $segundos - $dias * 86400 - $horas * 3600 - $minutos * 60;
        $texto = '';
        $texto .= $dias > 0 ? $dias.' día(s) ' : '';
        $texto .= $horas > 0 ? $horas.' hora(s) ' : '';
        $texto .= $minutos > 0 ? $minutos.' minuto(s) ' : '';
        $texto .= $segundos > 0 ? $segundos.' segundo(s)' : '';

        return $texto;
    }
}
