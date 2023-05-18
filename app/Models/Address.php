<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ["user_id", "address", "additional_address", "postal_code", "city", "firstname", 'lastname', "phone_number"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
