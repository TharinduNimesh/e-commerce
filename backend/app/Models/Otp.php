<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'otp',
        'user_id',
        'is_used',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
