<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'pet_id',
        'user_id',
        'name',
        'email',
        'phone',
        'reason',
    ];

    public function pet()
    {
        return $this->belongsTo(Pets::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
