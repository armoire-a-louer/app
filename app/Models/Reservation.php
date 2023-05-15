<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    public const STATUS_BASKET = "basket";
    public const STATUS_PAID = "paid";

    // AMOUNT MUST BE LIKE THIS 15€99 => 1599

    protected $fillable = ["product_size_color_id", "date", "status", "user_id", "price", "transaction_id"];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ProductSizeColor::class, 'product_size_color_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
