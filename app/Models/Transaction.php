<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    public const TYPE_PAYMENT = "payment";

    public const STATUS_WAITING = "waiting";
    public const STATUS_SUCCESS = "success";

    protected $fillable = ["payment_intent_id", "type", "status", "user_id", "amount", "title", "paid_at", "address_id"];

    protected $casts = [
		'paid_at' => 'datetime:d/m/Y'
	];

    /**
     * Accessor for the 'paid_at' attribute.
     *
     * @param mixed $value
     * @return string|null
     */
    public function getPaidAtFormatted($value)
    {
        if ($value === null) {
            return null;
        }

        return $value->format('d/m/Y');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
