<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LostPets extends Model
{
    use HasFactory;

    protected $fillable = [
        'species',
        'breed',
        'location',
        'years',
        'months',
        'gender',
        'description',
        'image',
        'user_id',
        'name',
        'size',
        'user_email',
        'phone_number'

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
