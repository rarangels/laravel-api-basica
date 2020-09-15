<?php

namespace Rarangels\ApiBasica\Models;

use Carbon\Carbon;
use Rarangels\ApiBasica\Traits\findByKey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Application
 *
 * @package Rarangels\ApiBasica\Models
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class Tokens extends Model
{
    use findByKey;

    /**
     * Application constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('api-basica.table_names.applications_tokens'));
    }

    /**
     * @var array
     */
    protected $fillable = [
        'application_id',
        'key',
        'token',
        'expired_at',
    ];

    /**
     * @param $query
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function scopeEnabled($query)
    {
        return $query->where('expired_at', '>', Carbon::now());
    }

    /**
     * @param $query
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function scopeExpired($query)
    {
        return $query->where('expired_at', '<=', Carbon::now());
    }

    /**
     * @param $token
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function ScopeWhereTokens($token, $key)
    {
        return self::where('token', $token)->where('key', $key);
    }

    /**
     * @param $token
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public static function checkTokens($token, $key)
    {
        return self::whereTokens($token, $key)->enabled()->exists();
    }

    /**
     * @param $token
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public static function findByTokens($token, $key)
    {
        return self::whereTokens($token, $key)->first();
    }

    /**
     * @param $token
     * @param $key
     * @return mixed
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public static function findByTokensEnabled($token, $key)
    {
        return self::whereTokens($token, $key)->enabled()->first();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function application()
    {
        return $this->belongsTo('Rarangels\ApiBasica\Models\Application', 'application_id', 'id');
    }
}
