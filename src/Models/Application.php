<?php

namespace Rarangels\ApiBasica\Models;

use Rarangels\ApiBasica\Traits\findByKey;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Application
 *
 * @package Rarangels\ApiBasica\Models
 * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
 */
class Application extends Model
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

        $this->setTable(config('api-basica.table_names.applications'));
    }

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'domain_url',
        'webhook_url',
        'css'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Rafael Agustin Rangel Sandoval <rarangels93@gmail.com>
     */
    public function tokens()
    {
        return $this->hasMany('Rarangels\ApiBasica\Models\Tokens', 'application_id', 'id');
    }
}
