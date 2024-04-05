<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Comic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'images',
        'price',
        'has_discount',
        'discount',
        'categories',
        'publisher',
        'issued_at',
        'created_by',
        'is_hidden',
        'is_removed',
        'buyers'
    ];
}
