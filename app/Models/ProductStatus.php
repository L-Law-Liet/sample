<?php

namespace App\Models;

use App\View\Components\forms\select;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const FOR_REPAIR = 1;
    public const REVISED = 2;
    public const IN_PROGRESS = 3;
    public const FOR_AUDIT = 4;
    public const AUDIT_FAIL = 5;
    public const REPAIRED = 7;
    public const UNABLE_TO_REPAIR = 6;

    public const FOR_GRAPH = [self::FOR_REPAIR, self::REVISED, self::REPAIRED, self::UNABLE_TO_REPAIR];

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeReport($query)
    {
        return $query->whereIn('id', self::FOR_GRAPH);
    }

    public static function REPAIRED_NAME()
    {
        return __('text.Repaired');
    }
}
