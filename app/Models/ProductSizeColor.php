<?php

namespace App\Models;

use App\Models\Product;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSizeColor extends Model implements HasMedia
{
    protected $table = "products_sizes_colors";

    use HasFactory, SoftDeletes, InteractsWithMedia;

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

    protected $fillable = [
        'product_id',
        'primary_color_id',
        'secondary_color_id',
        'size',
        'quantity',
        'model_size',
        'active'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function primaryColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'primary_color_id');
    }

    public function secondaryColor(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'secondary_color_id');
    }
}
