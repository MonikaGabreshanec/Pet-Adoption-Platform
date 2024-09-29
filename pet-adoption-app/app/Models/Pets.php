<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pets extends Model
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
        'health',
        'adopted'

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function adopter()
    {
        return $this->belongsTo(User::class, 'adopted_by');
    }
}
