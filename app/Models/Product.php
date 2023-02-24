<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public const SIZE_XS = 'xs';
    public const SIZE_S = 's';
    public const SIZE_M = 'm';
    public const SIZE_L = 'l';
    public const SIZE_XL = 'xl';

    public const SIZES = [
        self::SIZE_XS,
        self::SIZE_S,
        self::SIZE_M,
        self::SIZE_L,
        self::SIZE_XL,
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ProductSizeColor::class);
    }
}
