<?php

namespace Rarangels\ApiBasica\Models;

use Rarangels\ApiBasica\Traits\findByKey;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use findByKey;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('api-basica.table_names.applications'));
    }

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'domain_url',
        'key',
        'api_token',
        'api_token_expred_at',
    ];

    public static function findByToken($token)
    {
        return self::where('api_token', $token)->first();
    }
}
