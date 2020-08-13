<?php
/**
 * Created by PhpStorm.
 * User: rarangels
 * Date: 29/01/20
 * Time: 6:22 p. m.
 * Author: Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */

namespace Rarangels\ApiBasica\Traits;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Trait findByKey
 *
 * @package App\Traits
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
trait findByKey
{
    /**
     * @var string
     */
    protected $key_value_attribute = 'key';

    /**
     * @param $query
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function scopeOrWhereKeyValue($query, $key)
    {
        if (is_array($key) || $key instanceof Arrayable) {
            return $query->orWhereIn($this->key_value_attribute, $key);
        }

        return $query->orWhere($this->key_value_attribute, $key);
    }

    /**
     * @param $query
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function scopeWhereKeyValue($query, $key)
    {
        if (is_array($key) || $key instanceof Arrayable) {
            return $query->whereIn($this->key_value_attribute, $key);
        }

        return $query->where($this->key_value_attribute, $key);
    }

    /**
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public static function findByKey($key)
    {
        return self::whereKeyValue($key)->first();
    }

    /**
     * @param mixed ...$key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public static function findByKeys(...$key)
    {
        if (count($key) == 1) {
            return self::findByKey($key);
        } else {
            return self::whereKeyValue($key)->get();
        }
    }
}
