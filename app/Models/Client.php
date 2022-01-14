<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public const INTERNAL = 1;
    public const EXTERNAL = 1;
    public const UNKNOWN = -1;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInternal($query)
    {
        return $query->where('internal', true);
    }

    /**
     * @param $query
     * @return mixed
     *
     */
    public function scopeExternal($query)
    {
        return $query->where('internal', false);
    }
}
