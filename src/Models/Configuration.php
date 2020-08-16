<?php

namespace Rarangels\ApiBasica\Models;

use Illuminate\Database\Eloquent\Model;
use Rarangels\ApiBasica\Traits\findByKey;

class Configuration extends Model
{
    use findByKey;

    /**
     * @var string
     */
    protected $table = 'configurations';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'description',
        'value',
    ];

    protected $casts = [
        'value' => 'object',
    ];

    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = strtoupper($value);
    }

    public function setValueAttribute($value): void
    {
        if (is_object($value) && get_class($value) != 'stdClass') {
            $this->attributes['value'] = $value->toJson();
        } else {
            if (! is_null(json_decode($value))) {
                $this->attributes['value'] = $value;
            } else {
                if (is_string($value) || is_int($value) || is_object($value) || is_array($value)) {
                    $this->attributes['value'] = json_encode($value);
                } else {
                    $this->attributes['value'] = $value;
                }
            }
        }
    }
}
