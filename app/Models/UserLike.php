<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    protected $table = "users_likes";

    protected $fillable = ["user_id", "product_id"];

    use HasFactory;
}
