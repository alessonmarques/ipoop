<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'accessible',
        'latitude',
        'longitude',
        'cost',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}