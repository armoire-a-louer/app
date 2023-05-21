<?php

namespace App\Models;

use App\Models\Rating;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public const SEASONS = [
        "Été",
        "Automne",
        "Hivers",
        "Printemps"
    ];

    protected $fillable = ['category_id', 'brand_id', 'name', 'description', 'season', 'price_per_day', 'active'];

    protected $appends = ['image_url'];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getFirstMediaUrl('products')
        );
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductSizeColor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'materials_products');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
